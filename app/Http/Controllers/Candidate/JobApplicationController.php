<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $candidate = auth()->user();

        $query = JobListing::where('is_active', true)
            ->with(['category', 'employer']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        // Job Category filter (by name)
        if ($request->filled('job_category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->job_category);
            });
        }

        // Category filter (by ID - backward compatibility)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Country filter (specific countries)
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Location filter (city/region)
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Job Type (employment_type) filter
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        // Working Mode filter (on-site, remote, hybrid)
        if ($request->filled('working_mode')) {
            $query->where('working_mode', $request->working_mode);
        }

        // Hours of work (Full time/Part time) filter
        if ($request->filled('work_hours')) {
            $query->where('work_hours', $request->work_hours);
        }

        // Experience level filter
        if ($request->filled('experience_level')) {
            switch ($request->experience_level) {
                case 'no-experience':
                    $query->where('experience_required', 0);
                    break;
                case 'mid-level':
                    $query->whereBetween('experience_required', [2, 5]);
                    break;
                case 'senior':
                    $query->where('experience_required', '>=', 5);
                    break;
                case '1-2':
                    $query->whereBetween('experience_required', [1, 2]);
                    break;
                case '3-5':
                    $query->whereBetween('experience_required', [3, 5]);
                    break;
                case '5+':
                    $query->where('experience_required', '>=', 5);
                    break;
            }
        }

        // Education level filter
        if ($request->filled('education_level')) {
            $query->where('education_level', $request->education_level);
        }

        // Industry filter
        if ($request->filled('industry')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->industry);
            })->orWhere('industry', $request->industry);
        }

        // Visa Sponsorship filter
        if ($request->filled('visa_sponsorship')) {
            if ($request->visa_sponsorship === 'yes') {
                $query->where('visa_sponsorship', true);
            } elseif ($request->visa_sponsorship === 'no') {
                $query->where('visa_sponsorship', false);
            }
        }

        // Language filter
        if ($request->filled('language')) {
            if ($request->language === 'no-requirement') {
                $query->where(function($q) {
                    $q->whereNull('languages')
                      ->orWhereJsonLength('languages', 0);
                });
            } else {
                $query->whereJsonContains('languages', $request->language);
            }
        }

        // Salary period filter (hourly, monthly, etc.)
        if ($request->filled('salary_period')) {
            $query->where('salary_period', $request->salary_period);
        }

        // Salary range filter (support both naming conventions)
        $salaryMin = $request->filled('salary_min') ? $request->salary_min : $request->min_salary;
        $salaryMax = $request->filled('salary_max') ? $request->salary_max : $request->max_salary;
        
        if ($salaryMin) {
            $query->where(function($q) use ($salaryMin) {
                $q->where('salary_min', '>=', $salaryMin)
                  ->orWhere('salary_max', '>=', $salaryMin);
            });
        }
        if ($salaryMax) {
            $query->where(function($q) use ($salaryMax) {
                $q->where('salary_min', '<=', $salaryMax)
                  ->orWhere('salary_max', '<=', $salaryMax);
            });
        }

        // Date posted filter
        if ($request->filled('date_posted')) {
            switch ($request->date_posted) {
                case '3-days':
                    $query->where('created_at', '>=', now()->subDays(3));
                    break;
                case '48-hours':
                    $query->where('created_at', '>=', now()->subHours(48));
                    break;
                case '7-days':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case '30-days':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case '30-plus':
                    $query->where('created_at', '<', now()->subDays(30));
                    break;
            }
        }

        $jobs = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::where('is_active', true)->get();
        $myApplications = JobApplication::where('candidate_id', $candidate->id)
            ->pluck('job_id')
            ->toArray();

        return view('candidate.jobs.index', compact('jobs', 'categories', 'myApplications'));
    }

    public function show(JobListing $job)
    { 
        if (!$job->is_active) {
            abort(404);
        }

        $candidate = auth()->user();
        $hasApplied = JobApplication::where('candidate_id', $candidate->id)
            ->where('job_id', $job->id)
            ->exists();

        $job->load(['category', 'employer', 'applications']);

        return view('candidate.jobs.show', compact('job', 'hasApplied'));
    }

    public function apply(Request $request, JobListing $job)
    {
        $candidate = auth()->user();

        // Check if profile is verified
        if (!$candidate->candidateProfile || $candidate->candidateProfile->verification_status !== 'approved') {
            return back()->with('error', 'Your profile must be verified before applying to jobs.');
        }

        // Check if already applied
        if (JobApplication::where('candidate_id', $candidate->id)->where('job_id', $job->id)->exists()) {
            return back()->with('error', 'You have already applied for this job.');
        }

        // Check if job is accepting applications
        if (!$job->isAcceptingApplications()) {
            return back()->with('error', 'This job is no longer accepting applications.');
        }

        // Get PHP upload limits
        $uploadMaxFilesize = $this->convertToBytes(ini_get('upload_max_filesize'));
        $postMaxSize = $this->convertToBytes(ini_get('post_max_size'));
        $maxUploadMB = floor(min($uploadMaxFilesize, $postMaxSize) / (1024 * 1024));
        
        // Check if POST data was truncated (file too large for post_max_size)
        if (empty($_POST) && empty($_FILES) && $request->server('CONTENT_LENGTH') > 0) {
            \Log::error('POST data truncated - file too large', [
                'content_length' => $request->server('CONTENT_LENGTH'),
                'post_max_size' => ini_get('post_max_size'),
                'user_id' => auth()->id()
            ]);
            return back()->with('error', "The video file is too large. Your server allows maximum {$maxUploadMB}MB uploads. Please upload a smaller video or contact administrator to increase the limit.")->withInput();
        }

        // Check raw $_FILES for upload errors before Laravel processes it
        if (isset($_FILES['application_video']) && $_FILES['application_video']['error'] !== UPLOAD_ERR_OK && $_FILES['application_video']['error'] !== UPLOAD_ERR_NO_FILE) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => "The video file is too large. Maximum allowed by server is {$maxUploadMB}MB. Please upload a smaller video.",
                UPLOAD_ERR_FORM_SIZE => 'The video file is too large for this form.',
                UPLOAD_ERR_PARTIAL => 'The video was only partially uploaded. Please try again.',
                UPLOAD_ERR_NO_TMP_DIR => 'Server configuration error. Please contact support.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to save video to disk. Please contact support.',
                UPLOAD_ERR_EXTENSION => 'Video upload was stopped by a server extension.',
            ];
            $errorCode = $_FILES['application_video']['error'];
            $errorMessage = $errorMessages[$errorCode] ?? 'Failed to upload video. Error code: ' . $errorCode;
            \Log::error('Video upload error from $_FILES', ['error_code' => $errorCode, 'user_id' => auth()->id()]);
            return back()->with('error', $errorMessage)->withInput();
        }

        // Check if video file was uploaded but had an error (Laravel level)
        if ($request->hasFile('application_video')) {
            $file = $request->file('application_video');
            if (!$file->isValid()) {
                $errorCode = $file->getError();
                \Log::error('Video upload error - file invalid', ['error_code' => $errorCode, 'user_id' => auth()->id()]);
                return back()->with('error', "The video file could not be uploaded. Maximum allowed by server is {$maxUploadMB}MB. Error code: {$errorCode}")->withInput();
            }
        }

        // Calculate max size in KB based on PHP settings (use smaller of the two limits)
        $maxSizeKB = floor(min($uploadMaxFilesize, $postMaxSize) / 1024);
        
        // Validate video if job requires it
        $videoRules = [];
        if ($job->requires_video) {
            $videoRules['application_video'] = "required|mimes:mp4,mov,avi,wmv|max:{$maxSizeKB}";
        } else {
            $videoRules['application_video'] = "nullable|mimes:mp4,mov,avi,wmv|max:{$maxSizeKB}";
        }

        $validated = $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
        ] + $videoRules, [
            'application_video.required' => 'A video is required for this job application.',
            'application_video.mimes' => 'The video must be a file of type: MP4, MOV, AVI, or WMV.',
            'application_video.max' => "The video may not be larger than {$maxUploadMB}MB (server limit).",
            'application_video.uploaded' => "The video failed to upload. Maximum allowed is {$maxUploadMB}MB.",
        ]);

        // Handle video upload
        $videoPath = null;
        if ($request->hasFile('application_video')) {
            try {
                $file = $request->file('application_video');
                
                // Ensure directory exists in public folder
                $directory = public_path('application-videos');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
                
                // Generate unique filename
                $extension = $file->getClientOriginalExtension();
                $fileName = 'video_' . auth()->id() . '_' . $job->id . '_' . time() . '.' . $extension;
                $destinationPath = $directory . '/' . $fileName;
                
                // Move uploaded file to public directory
                if ($file->move($directory, $fileName)) {
                    $videoPath = 'application-videos/' . $fileName;
                    \Log::info('Video uploaded successfully', ['path' => $videoPath, 'user_id' => auth()->id()]);
                } else {
                    return back()->with('error', 'Failed to save video file. Please try again.')->withInput();
                }
            } catch (\Exception $e) {
                \Log::error('Video upload error: ' . $e->getMessage(), ['user_id' => auth()->id(), 'trace' => $e->getTraceAsString()]);
                return back()->with('error', 'An error occurred while uploading the video: ' . $e->getMessage())->withInput();
            }
        } elseif ($job->requires_video) {
            return back()->with('error', 'Video is required for this job application.')->withInput();
        }

        JobApplication::create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'video_path' => $videoPath,
            'status' => 'pending',
        ]);

        return redirect()->route('candidate.applications.index')
            ->with('success', 'Application submitted successfully!');
    }

    public function applications()
    {
        $candidate = auth()->user();

        $applications = JobApplication::where('candidate_id', $candidate->id)
            ->with(['job', 'job.category', 'job.employer'])
            ->latest()
            ->paginate(20);

        return view('candidate.applications.index', compact('applications'));
    }

    public function showApplication(JobApplication $application)
    {
        if ($application->candidate_id !== auth()->id()) {
            abort(403);
        }

        $application->load(['job', 'job.category', 'job.employer']);

        return view('candidate.applications.show', compact('application'));
    }

    /**
     * Convert PHP size string (like "2M", "128K") to bytes
     */
    private function convertToBytes($size)
    {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $value = (int) $size;
        
        switch ($last) {
            case 'g':
                $value *= 1024 * 1024 * 1024;
                break;
            case 'm':
                $value *= 1024 * 1024;
                break;
            case 'k':
                $value *= 1024;
                break;
        }
        
        return $value;
    }
}

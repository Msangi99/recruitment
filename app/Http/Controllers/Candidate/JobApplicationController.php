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
                    $query->where(function($q) {
                        $q->where('experience_required', 0)->orWhere('experience_years', 0);
                    });
                    break;
                case 'mid-level':
                    $query->where(function($q) {
                        $q->whereBetween('experience_required', [2, 5])->orWhereBetween('experience_years', [2, 5]);
                    });
                    break;
                case 'senior':
                    $query->where(function($q) {
                        $q->where('experience_required', '>=', 5)->orWhere('experience_years', '>=', 5);
                    });
                    break;
                case '1-2':
                    $query->where(function($q) {
                        $q->whereBetween('experience_required', [1, 2])->orWhereBetween('experience_years', [1, 2]);
                    });
                    break;
                case '3-5':
                    $query->where(function($q) {
                        $q->whereBetween('experience_required', [3, 5])->orWhereBetween('experience_years', [3, 5]);
                    });
                    break;
                case '5+':
                    $query->where(function($q) {
                        $q->where('experience_required', '>=', 5)->orWhere('experience_years', '>=', 5);
                    });
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
        
        // Check if video/file data was truncated
        if (empty($_POST) && empty($_FILES) && $request->server('CONTENT_LENGTH') > 0) {
            return back()->with('error', "The upload file is too large. Please upload a smaller file (max 5MB).")->withInput();
        }

        $validated = $request->validate([
            'cover_letter' => 'nullable|string',
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB limit
            'application_video' => 'nullable|mimes:mp4,mov,avi,wmv|max:102400', // 100MB max if provided
        ], [
            'cv_file.required' => 'Please upload your CV / Resume.',
            'cv_file.mimes' => 'The CV must be a PDF, DOC, or DOCX file.',
            'cv_file.max' => 'The CV file size must not exceed 5MB.',
        ]);

        // Handle CV upload
        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $fileName = 'cv_' . auth()->id() . '_' . $job->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $cvPath = $file->storeAs('cv_uploads', $fileName, 'public');
        }

        // Handle video upload (optional now)
        $videoPath = null;
        if ($request->hasFile('application_video')) {
            $file = $request->file('application_video');
            $fileName = 'video_' . auth()->id() . '_' . $job->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $videoPath = $file->storeAs('application_videos', $fileName, 'public');
        }

        JobApplication::create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'cv_path' => $cvPath,
            'video_path' => $videoPath,
            'status' => 'pending',
        ]);

        return redirect()->route('public.jobs.show', $job)
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

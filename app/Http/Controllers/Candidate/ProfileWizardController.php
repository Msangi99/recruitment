<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CandidateProfile;
use App\Models\Category;
use App\Models\Skill;
use App\Models\Language;
use App\Models\WorkExperience;
use App\Models\Education;
use App\Models\Document;
use App\Models\JobListing;
use App\Models\Training;
use Illuminate\Support\Facades\Log;

class ProfileWizardController extends Controller
{
    public function show($step = 1)
    {
        $step = intval($step);
        if ($step < 1 || $step > 12) {
            return redirect()->route('candidate.wizard.show', ['step' => 1]);
        }

        $user = auth()->user();
        $profile = $user->candidateProfile;

        // Ensure profile exists
        if (!$profile) {
            $profile = $user->candidateProfile()->create();
        }

        $viewData = [
            'step' => $step,
            'profile' => $profile,
            'user' => $user,
        ];

        // Load specific data for steps
        switch ($step) {
            case 3: // Job Preferences
                $viewData['categories'] = Category::orderBy('name')->get();
                $viewData['jobTitles'] = \App\Models\JobTitle::orderBy('name')->pluck('name');
                break;
            case 4: // Skills
                $viewData['allSkills'] = Skill::orderBy('name')->get();
                // Get existing skills
                break;
            case 10: // Compliance & Media
                $viewData['complianceDocuments'] = Document::where('user_id', $user->id)
                    ->whereIn('document_type', ['Medical Fitness Status', 'Police Clearance Status'])
                    ->latest()
                    ->get();
                break;
            case 9: // Languages
                $viewData['allLanguages'] = Language::orderBy('name')->get();
                break;
            case 11: // Review & Submit
                $profile->load(['categories', 'skills', 'workExperiences', 'educations', 'languages']);
                break;
        }

        return view('candidate.profile.wizard.step' . $step, $viewData);
    }

    public function process(Request $request, $step)
    {
        $step = intval($step);
        $user = auth()->user();
        $profile = $user->candidateProfile;

        // Validation and Saving Logic per step
        switch ($step) {
            case 1: // Account Create (handled by Register, but if editing...)
                // Just update basic user info if needed
                break;

            case 2: // Basic Info
                $validated = $request->validate([
                    'citizenship' => 'required|string|max:255',
                    'gender' => 'required|string|in:male,female,other',
                    'date_of_birth' => 'required|date',
                    'city' => 'required|string|max:255',
                    'country' => 'required|string|max:255',
                ]);

                $profile->update([
                    'citizenship' => $validated['citizenship'],
                    'gender' => $validated['gender'],
                    'date_of_birth' => $validated['date_of_birth'],
                    'location' => $validated['city'] . ', ' . $validated['country'],
                ]);
                break;

            case 3: // Job Preferences
                $validated = $request->validate([
                    'titles' => 'required|array',
                    'titles.*' => 'nullable|string|max:255',
                    'categories' => 'required|array',
                    'preferred_job_titles' => 'required|array', 
                    'preferred_job_titles.*' => 'string',
                    'availability_status' => 'required|string',
                    // employment_type handling if needed (add to model/migration if likely new)
                ]);

                // Filter out empty titles
                $cleanTitles = array_filter($validated['titles']);

                $profile->update([
                    'title' => array_values($cleanTitles), // Reset keys
                    // 'experience_category_id' => $validated['categories'][0] ?? null, // Keep for backward compatibility if needed, or remove
                    'availability_status' => $validated['availability_status'],
                    'preferred_job_titles' => $validated['preferred_job_titles'],
                ]);

                // Sync categories
                if (!empty($validated['categories'])) {
                    $profile->categories()->sync($validated['categories']);

                    // Update the primary category for single-category logic compatibility
                    $profile->experience_category_id = $validated['categories'][0];
                    $profile->save();
                } else {
                    $profile->categories()->detach();
                }

                break;

            case 4: // Skills
                $validated = $request->validate([
                    'skills' => 'required|array|max:15',
                    'skills.*' => 'string',
                ]);

                // Logic to sync skills
                // Assuming skills are sent as IDs if existing, or names if new. 
                // For simplicity, let's assume UI sends generic tag strings

                $skillIds = [];
                foreach ($validated['skills'] as $skillName) {
                    $skill = Skill::firstOrCreate(['name' => $skillName]);
                    $skillIds[] = $skill->id;
                }

                $profile->skills()->sync($skillIds);
                break;

            case 5: // Work Experience (Continue action)
                // Update the "International Experience" checkbox
                $profile->update([
                    'international_experience' => $request->boolean('international_experience')
                ]);
                break;

            case 6: // Education (Continue action)
                // Nothing specific to save on continue, unless "Certifications" field is added
                if ($request->has('certifications')) {
                    // handled if column exists
                }
                break;

            case 7: // Professional Summary
                $validated = $request->validate([
                    'headline' => 'required|string|max:255',
                    'description' => 'required|string',
                    'years_of_experience' => 'required|integer|min:0|max:50',
                ]);

                $profile->update([
                    'headline' => $validated['headline'],
                    'description' => $validated['description'],
                    'years_of_experience' => $validated['years_of_experience'],
                ]);
                break;

            case 8: // International Readiness
                $validated = $request->validate([
                    'willing_to_relocate' => 'required|boolean',
                    'preferred_destinations' => 'nullable|array',
                    'preferred_destinations.*' => 'string|max:255',
                    'passport_status' => 'required|string',
                ]);

                $profile->update([
                    'willing_to_relocate' => $validated['willing_to_relocate'],
                    'preferred_destinations' => $validated['preferred_destinations'] ?? [],
                    'passport_status' => $validated['passport_status'],
                ]);
                break;

            case 9: // Languages
                $validated = $request->validate([
                    'languages' => 'required|array',
                    'languages.*.id' => 'required|exists:languages,id',
                    'languages.*.proficiency' => 'required|string',
                ]);

                $syncData = [];
                foreach ($validated['languages'] as $lang) {
                    if (!empty($lang['id'])) {
                        $syncData[$lang['id']] = ['proficiency' => $lang['proficiency']];
                    }
                }

                $profile->languages()->sync($syncData);
                break;

            case 10: // Compliance & Documents
                // Requirement: "Before submit, candidate must tick: I consent..."
                $validated = $request->validate([
                    'consent' => 'required|accepted',
                    'medical_clearance' => 'nullable|string|in:Fit,Pending,Unfit',
                    'police_clearance' => 'nullable|string|in:Cleared,Pending,Disqualified',
                ]);

                $profile->update([
                    'medical_clearance' => $validated['medical_clearance'] ?? $profile->medical_clearance,
                    'police_clearance' => $validated['police_clearance'] ?? $profile->police_clearance,
                ]);
                break;

            case 11: // Review & Submit
                // Mark profile as pending verification or active
                // If default is pending, we might no need to change it, or we can explicitely set it
                $profile->update([
                    'verification_status' => 'pending',
                    'is_available' => true,
                ]);
                break;

            case 12: // Completion
                break;

            // ... other cases
        }

        $nextStep = $step + 1;

        // If we processed step 10, we go to step 11 (Completion View)
        // If we processed step 11, we go to dashboard
        if ($nextStep > 12) {
            return redirect()->route('candidate.dashboard')->with('success', 'Profile completed!');
        }

        return redirect()->route('candidate.wizard.show', ['step' => $nextStep]);
    }

    public function storeWorkExperience(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'employer' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();
        $profile = $user->candidateProfile;

        $profile->workExperiences()->create($validated);

        return redirect()->back()->with('success', 'Work experience added.');
    }

    public function destroyWorkExperience(WorkExperience $workExperience)
    {
        // Check ownership
        if ($workExperience->candidate_profile_id !== auth()->user()->candidateProfile->id) {
            abort(403);
        }

        $workExperience->delete();

        return redirect()->back()->with('success', 'Work experience removed.');
    }

    public function storeEducation(Request $request)
    {
        $validated = $request->validate([
            'level' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
        ]);

        $user = auth()->user();
        $profile = $user->candidateProfile;

        $profile->educations()->create($validated);

        return redirect()->back()->with('success', 'Education added.');
    }

    public function destroyEducation(Education $education)
    {
        // Check ownership
        if ($education->candidate_profile_id !== auth()->user()->candidateProfile->id) {
            abort(403);
        }

        $education->delete();

        return redirect()->back()->with('success', 'Education removed.');
    }

    public function storeTraining(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $user = auth()->user();
        $profile = $user->candidateProfile;

        $profile->trainings()->create($validated);

        return redirect()->back()->with('success', 'Training added.');
    }

    public function destroyTraining(Training $training)
    {
        // Check ownership
        if ($training->candidate_profile_id !== auth()->user()->candidateProfile->id) {
            abort(403);
        }

        $training->delete();

        return redirect()->back()->with('success', 'Training removed.');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|max:3072', // 3MB
        ]);

        $user = auth()->user();
        $profile = $user->candidateProfile;

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            // Generate clean filename
            $originalName = $file->getClientOriginalName();
            $cleanName = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $originalName);
            $filename = time() . '_' . $cleanName;

            // Build user-specific path
            $directory = 'profile-pictures/' . $user->id;
            $destinationPath = public_path($directory);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            try {
                $file->move($destinationPath, $filename);
                $relativePath = $directory . '/' . $filename;

                // Delete old picture if it exists
                if ($profile->profile_picture) {
                    $oldPath = public_path($profile->profile_picture);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $profile->update(['profile_picture' => $relativePath]);

                return response()->json([
                    'success' => true,
                    'path' => asset($relativePath)
                ]);
            } catch (\Exception $e) {
                \Log::error('Profile photo upload failed: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Upload failed'], 500);
            }
        }

        return response()->json(['success' => false], 400);
    }

    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video_cv' => 'required|mimetypes:video/mp4,video/quicktime,video/webm,video/x-msvideo,video/mpeg,video/3gpp,video/x-matroska|max:102400', // 100MB
        ]);

        $user = auth()->user();
        $profile = $user->candidateProfile;

        if ($request->hasFile('video_cv')) {
            $file = $request->file('video_cv');

            // Generate clean filename
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();
            $cleanName = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $originalName);
            $filename = time() . '_' . $cleanName;

            // Build user-specific path
            $directory = 'uploads/video_cvs/' . $user->id;
            $destinationPath = public_path($directory);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            try {
                $file->move($destinationPath, $filename);
                $relativePath = $directory . '/' . $filename;

                // Delete old video if it exists
                if ($profile->video_cv) {
                    $oldPath = public_path($profile->video_cv);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $profile->update(['video_cv' => $relativePath]);

                // Sync with Documents table
                \App\Models\Document::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'document_type' => 'video_cv',
                    ],
                    [
                        'file_name' => $cleanName,
                        'file_path' => $relativePath,
                        'file_type' => $mimeType,
                        'file_size' => $fileSize,
                        'verification_status' => 'pending',
                    ]
                );

                return response()->json([
                    'success' => true,
                    'path' => asset($relativePath)
                ]);
            } catch (\Exception $e) {
                \Log::error('Video CV upload failed: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Upload failed'], 500);
            }
        }

        return response()->json(['success' => false], 400);
    }

    public function storeComplianceDocument(Request $request)
    {
        $validated = $request->validate([
            'document_type' => 'required|string|in:Medical Fitness Status,Police Clearance Status',
            'document' => 'required|file|mimes:pdf|max:5120', // 5MB max, PDF only as requested
        ]);

        $user = auth()->user();

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();

            $cleanName = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $originalName);
            $fileName = time() . '_' . $cleanName;

            $directory = 'documents/' . $user->id;
            $destinationPath = public_path($directory);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            try {
                $file->move($destinationPath, $fileName);
                $filePath = $directory . '/' . $fileName;

                Document::create([
                    'user_id' => $user->id,
                    'document_type' => $validated['document_type'],
                    'file_name' => $cleanName,
                    'file_path' => $filePath,
                    'file_type' => $mimeType,
                    'file_size' => $fileSize,
                    'verification_status' => 'pending',
                ]);

                return redirect()->back()->with('success', $validated['document_type'] . ' uploaded successfully.');
            } catch (\Exception $e) {
                Log::error('Compliance document upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Upload failed. Please try again.');
            }
        }

        return redirect()->back()->with('error', 'No file selected.');
    }

    public function destroyComplianceDocument(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        $absolutePath = public_path($document->file_path);
        if (file_exists($absolutePath)) {
            @unlink($absolutePath);
        }

        $document->delete();

        return redirect()->back()->with('success', 'Document removed successfully.');
    }
}

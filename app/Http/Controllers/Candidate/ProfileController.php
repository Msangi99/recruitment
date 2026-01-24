<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\Skill;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function show()
    {
        $candidate = auth()->user();
        $profile = $candidate->candidateProfile;
        
        if ($profile) {
            $profile->load(['skills', 'languages', 'experienceCategory']);
        }
        
        return view('candidate.profile.show', compact('profile'));
    }

    public function create()
    {
        $candidate = auth()->user();
        
        // Check if profile already exists
        if ($candidate->candidateProfile) {
            return redirect()->route('candidate.profile.show')
                ->with('info', 'Profile already exists. You can edit it instead.');
        }

        $skills = Skill::orderBy('name')->get();
        $languages = Language::orderBy('name')->get();

        return view('candidate.profile.create', compact('skills', 'languages'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'date_of_birth' => 'required|date|before:today',
            'location' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
        ]);

        $candidate = auth()->user();
        
        // Create or update profile
        $profile = CandidateProfile::updateOrCreate(
            ['user_id' => $candidate->id],
            array_merge($validated, ['verification_status' => 'pending'])
        );

        return response()->json(['success' => true, 'step' => 2]);
    }

    public function storeStep2(Request $request)
    {
        // Handle JSON strings for skills and languages
        $skills = $request->input('skills');
        $languages = $request->input('languages');
        
        if (is_string($skills)) {
            $skills = json_decode($skills, true);
        }
        if (is_string($languages)) {
            $languages = json_decode($languages, true);
        }

        $preferredTitles = $request->input('preferred_job_titles');
        if (is_string($preferredTitles)) {
            $preferredTitles = json_decode($preferredTitles, true);
        }
        if (!is_array($preferredTitles)) {
            $preferredTitles = [];
        }

        // Ensure they are arrays
        if (!is_array($skills)) {
            $skills = [];
        }
        if (!is_array($languages)) {
            $languages = [];
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'description' => 'required|string',
            'education_level' => 'required|string|max:100',
            'experience_level' => 'nullable|string|max:100',
            'course_studied' => 'required|string|max:255',
            'years_of_experience' => 'required|integer|min:0|max:50',
            'experience_description' => 'required|string',
            'experience_category_id' => 'required|exists:categories,id',
        ]);

        // Validate skills and languages
        if (empty($skills) || count($skills) === 0) {
            return response()->json(['success' => false, 'message' => 'Please add at least one skill.'], 422);
        }
        if (empty($languages) || count($languages) === 0) {
            return response()->json(['success' => false, 'message' => 'Please add at least one language.'], 422);
        }

        $candidate = auth()->user();
        $profile = $candidate->candidateProfile;
        
        if (!$profile) {
            return response()->json(['success' => false, 'message' => 'Please complete step 1 first'], 400);
        }

        // Update profile basic info
        $profile->update(array_merge($validated, ['preferred_job_titles' => $preferredTitles]));

        // Log what we're syncing
        Log::info('StoreStep2 - syncing skills and languages', [
            'user_id' => auth()->id(),
            'profile_id' => $profile->id,
            'skills' => $skills,
            'languages' => $languages,
        ]);

        // Sync skills - create skills if they don't exist
        $skillIds = [];
        foreach ($skills as $skillName) {
            $skillName = trim($skillName);
            if (!empty($skillName)) {
                $skill = \App\Models\Skill::firstOrCreate(['name' => $skillName]);
                $skillIds[] = $skill->id;
            }
        }
        $profile->skills()->sync($skillIds);

        // Sync languages - create languages if they don't exist
        $languageIds = [];
        foreach ($languages as $languageName) {
            $languageName = trim($languageName);
            if (!empty($languageName)) {
                $language = \App\Models\Language::firstOrCreate(['name' => $languageName]);
                $languageIds[] = $language->id;
            }
        }
        $profile->languages()->sync($languageIds);

        Log::info('StoreStep2 - sync complete', [
            'user_id' => auth()->id(),
            'skill_ids' => $skillIds,
            'language_ids' => $languageIds,
        ]);

        return response()->json(['success' => true, 'step' => 3]);
    }

    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            'expected_salary' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'target_destination' => 'nullable|string|max:255',
            'is_available' => 'boolean',
            'passport_status' => 'nullable|string|max:50',
            'willing_to_relocate' => 'nullable|boolean',
            'availability_status' => 'nullable|string|max:50',
            'medical_clearance' => 'nullable|string|max:50',
            'police_clearance' => 'nullable|string|max:50',
        ]);

        $candidate = auth()->user();
        $profile = $candidate->candidateProfile;
        
        if (!$profile) {
            return response()->json(['success' => false, 'message' => 'Please complete previous steps first'], 400);
        }

        $validated['is_available'] = $request->has('is_available');
        $validated['willing_to_relocate'] = $request->has('willing_to_relocate');
        $profile->update($validated);
        return response()->json(['success' => true, 'step' => 4]);
    }

    public function edit()
    {
        $candidate = auth()->user();
        $profile = $candidate->candidateProfile;
        
        if (!$profile) {
            return redirect()->route('candidate.profile.create')
                ->with('error', 'Please create your profile first.');
        }

        $profile->load(['skills', 'languages', 'experienceCategory']);
        
        $skills = Skill::orderBy('name')->get();
        $languages = Language::orderBy('name')->get();

        return view('candidate.profile.edit', compact('profile', 'skills', 'languages'));
    }

    public function update(Request $request)
    {
        $candidate = auth()->user();
        $profile = $candidate->candidateProfile;
        
        // Debug: Log request details
        Log::info('Profile update request received', [
            'user_id' => auth()->id(),
            'has_file' => $request->hasFile('profile_picture'),
            'all_files' => array_keys($request->allFiles()),
            'method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'post_data' => $request->all(),
            'files_array' => $_FILES ?? 'No $_FILES'
        ]);
        
        if (!$profile) {
            return redirect()->route('candidate.profile.create')
                ->with('error', 'Please create your profile first.');
        }

        // Handle skills and languages - can come as:
        // 1. Array (skills[]) from hidden inputs
        // 2. JSON string
        // 3. Comma-separated text (skills_text)
        $skills = $request->input('skills', []);
        $languages = $request->input('languages', []);
        
        // Check if comma-separated text was provided (skills_text, languages_text)
        $skillsText = $request->input('skills_text', '');
        $languagesText = $request->input('languages_text', '');
        
        // If comma-separated text provided, parse it
        if (!empty($skillsText)) {
            $skills = array_values(array_filter(array_map('trim', explode(',', $skillsText))));
        }
        if (!empty($languagesText)) {
            $languages = array_values(array_filter(array_map('trim', explode(',', $languagesText))));
        }
        
        // If skills/languages come as a single JSON string, decode it
        if (is_string($skills) && !empty($skills)) {
            $decoded = json_decode($skills, true);
            $skills = is_array($decoded) ? $decoded : [];
        }
        if (is_string($languages) && !empty($languages)) {
            $decoded = json_decode($languages, true);
            $languages = is_array($decoded) ? $decoded : [];
        }

        // Handle preferred_job_titles - similar logic
        $preferredTitles = $request->input('preferred_job_titles', []);
        $preferredTitlesText = $request->input('preferred_job_titles_text', '');
        if (!empty($preferredTitlesText)) {
            $preferredTitles = array_values(array_filter(array_map('trim', explode(',', $preferredTitlesText))));
        }
        if (is_string($preferredTitles) && !empty($preferredTitles)) {
            $decoded = json_decode($preferredTitles, true);
            $preferredTitles = is_array($decoded) ? $decoded : [];
        }
        if (!is_array($preferredTitles)) {
            $preferredTitles = [];
        }
        
        // Ensure they are arrays
        if (!is_array($skills)) {
            $skills = [];
        }
        if (!is_array($languages)) {
            $languages = [];
        }

        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'education_level' => 'required|string|max:100',
            'experience_level' => 'nullable|string|max:100',
            'course_studied' => 'required|string|max:255',
            'years_of_experience' => 'required|integer|min:0|max:50',
            'experience_description' => 'required|string',
            'experience_category_id' => 'required|exists:categories,id',
            'expected_salary' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'target_destination' => 'nullable|string|max:255',
            'is_available' => 'boolean',
            'passport_status' => 'nullable|string|max:50',
            'willing_to_relocate' => 'nullable|boolean',
            'availability_status' => 'nullable|string|max:50',
            'medical_clearance' => 'nullable|string|max:50',
            'police_clearance' => 'nullable|string|max:50',
            'video_cv' => 'nullable|mimes:mp4,mov,avi,wmv|max:20480',
        ]);

        // Handle Video CV Upload
        if ($request->hasFile('video_cv')) {
            try {
                $videoFile = $request->file('video_cv');
                
                // Ensure directory exists in public folder
                $videoDirectory = public_path('video-cvs');
                if (!file_exists($videoDirectory)) {
                    mkdir($videoDirectory, 0755, true);
                }
                
                // Delete old video if exists
                if ($profile->video_cv) {
                    $oldVideoPath = public_path($profile->video_cv);
                    if (file_exists($oldVideoPath)) {
                        unlink($oldVideoPath);
                    }
                }
                
                // Generate unique filename
                $videoExtension = $videoFile->getClientOriginalExtension();
                $videoFileName = 'video_cv_' . auth()->id() . '_' . time() . '.' . $videoExtension;
                
                // Move uploaded file to public directory
                if ($videoFile->move($videoDirectory, $videoFileName)) {
                    $validated['video_cv'] = 'video-cvs/' . $videoFileName;
                } else {
                    return back()->withErrors(['video_cv' => 'Failed to upload video. Please try again.'])->withInput();
                }

            } catch (\Exception $e) {
                Log::error('Video CV upload error: ' . $e->getMessage());
                return back()->withErrors(['video_cv' => 'An error occurred while uploading the video.'])->withInput();
            }
        }

        // Validate skills and languages
        if (!empty($skills)) {
            // Validate each skill
            foreach ($skills as $skill) {
                if (!is_string($skill) || strlen($skill) > 100) {
                    return back()->withErrors(['skills' => 'Each skill must be a string with max 100 characters.'])->withInput();
                }
            }
        } else {
            // Keep existing skills if not provided in form - extract names from relationship
            $profile->load('skills');
            $skills = $profile->skills ? $profile->skills->pluck('name')->toArray() : [];
        }

        if (!empty($languages)) {
            // Validate each language
            foreach ($languages as $language) {
                if (!is_string($language) || strlen($language) > 50) {
                    return back()->withErrors(['languages' => 'Each language must be a string with max 50 characters.'])->withInput();
                }
            }
        } else {
            // Keep existing languages if not provided in form - extract names from relationship
            $profile->load('languages');
            $languages = $profile->languages ? $profile->languages->pluck('name')->toArray() : [];
        }

        $validated['is_available'] = $request->has('is_available');
        $validated['willing_to_relocate'] = $request->has('willing_to_relocate');
        $validated['preferred_job_titles'] = $preferredTitles;

        // Handle profile picture upload with error handling
        if ($request->hasFile('profile_picture')) {
            try {
                $file = $request->file('profile_picture');
                
                // Log initial file info
                Log::info('Profile picture upload started', [
                    'user_id' => auth()->id(),
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'is_valid' => $file->isValid()
                ]);
                
                // Check if file is valid
                if (!$file->isValid()) {
                    Log::error('Invalid file uploaded', [
                        'user_id' => auth()->id(),
                        'error' => $file->getError(),
                        'error_message' => $file->getErrorMessage()
                    ]);
                    return back()->withErrors(['profile_picture' => 'Invalid file uploaded. Please try again.'])->withInput();
                }
                
                // Additional validation
                $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                $maxSize = 2048; // 2MB in KB
                
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    Log::warning('Invalid MIME type', [
                        'user_id' => auth()->id(),
                        'mime_type' => $file->getMimeType(),
                        'allowed' => $allowedMimes
                    ]);
                    return back()->withErrors(['profile_picture' => 'Invalid file type. Please upload a JPEG, PNG, or GIF image.'])->withInput();
                }
                
                if ($file->getSize() > ($maxSize * 1024)) {
                    Log::warning('File too large', [
                        'user_id' => auth()->id(),
                        'file_size' => $file->getSize(),
                        'max_size' => $maxSize * 1024
                    ]);
                    return back()->withErrors(['profile_picture' => 'File size exceeds 2MB limit. Please upload a smaller image.'])->withInput();
                }
                
                // Ensure directory exists in public folder
                $directory = public_path('profile-pictures');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                    Log::info('Created profile-pictures directory', ['path' => $directory]);
                }
                
                // Delete old profile picture if exists
                if ($profile->profile_picture) {
                    $oldPath = public_path($profile->profile_picture);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                        Log::info('Deleted old profile picture', ['path' => $oldPath]);
                    }
                }
                
                // Generate unique filename
                $extension = $file->getClientOriginalExtension();
                $fileName = 'profile_' . auth()->id() . '_' . time() . '.' . $extension;
                $destinationPath = $directory . '/' . $fileName;
                
                // Move uploaded file to public directory
                if (!$file->move($directory, $fileName)) {
                    Log::error('Failed to move uploaded file', [
                        'user_id' => auth()->id(),
                        'file_name' => $file->getClientOriginalName(),
                        'destination' => $destinationPath
                    ]);
                    return back()->withErrors(['profile_picture' => 'Failed to upload image. Please try again.'])->withInput();
                }
                
                // Verify file was stored
                if (!file_exists($destinationPath)) {
                    Log::error('Profile picture file not found after upload', [
                        'user_id' => auth()->id(),
                        'destination' => $destinationPath,
                        'directory_exists' => file_exists($directory),
                        'directory_writable' => is_writable($directory)
                    ]);
                    return back()->withErrors(['profile_picture' => 'File was uploaded but could not be verified. Please check server permissions.'])->withInput();
                }
                
                // Store relative path (from public directory)
                $validated['profile_picture'] = 'profile-pictures/' . $fileName;
                
                // Log successful upload with full details
                Log::info('Profile picture uploaded successfully', [
                    'user_id' => auth()->id(),
                    'path' => $validated['profile_picture'],
                    'full_path' => $destinationPath,
                    'file_size' => filesize($destinationPath),
                    'url' => asset($validated['profile_picture']),
                    'exists' => file_exists($destinationPath)
                ]);
            } catch (\Exception $e) {
                Log::error('Profile picture upload exception', [
                    'user_id' => auth()->id(),
                    'file_name' => isset($file) ? $file->getClientOriginalName() : 'unknown',
                    'file_size' => isset($file) ? $file->getSize() : 0,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->withErrors(['profile_picture' => 'An error occurred while uploading the image: ' . $e->getMessage()])->withInput();
            }
        } else {
            Log::warning('No file in request', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('profile_picture'),
                'all_files' => array_keys($request->allFiles())
            ]);
        }

        // If profile was verified, reset to pending after edit
        if ($profile->verification_status === 'approved') {
            $validated['verification_status'] = 'pending';
            $validated['is_public'] = false;
        }

        $profile->update($validated);
        
        // Refresh profile to get updated data
        $profile->refresh();

        // Log what we're about to sync
        Log::info('Profile update - syncing skills and languages', [
            'user_id' => auth()->id(),
            'profile_id' => $profile->id,
            'skills_to_sync' => $skills,
            'languages_to_sync' => $languages,
        ]);

        // Sync skills - create skills if they don't exist
        $skillIds = [];
        foreach ($skills as $skillName) {
            $skillName = trim($skillName);
            if (!empty($skillName)) {
                $skill = \App\Models\Skill::firstOrCreate(['name' => $skillName]);
                $skillIds[] = $skill->id;
            }
        }
        $profile->skills()->sync($skillIds);

        // Sync languages - create languages if they don't exist
        $languageIds = [];
        foreach ($languages as $languageName) {
            $languageName = trim($languageName);
            if (!empty($languageName)) {
                $language = \App\Models\Language::firstOrCreate(['name' => $languageName]);
                $languageIds[] = $language->id;
            }
        }
        $profile->languages()->sync($languageIds);
        
        Log::info('Profile update - sync complete', [
            'user_id' => auth()->id(),
            'skill_ids_synced' => $skillIds,
            'language_ids_synced' => $languageIds,
        ]);

        $successMessage = 'Profile updated successfully.';
        if ($request->hasFile('profile_picture')) {
            $successMessage .= ' Profile picture uploaded successfully.';
        }
        if ($profile->verification_status === 'pending') {
            $successMessage .= ' Your profile will be reviewed again by admin.';
        }

        return redirect()->route('candidate.profile.show')
            ->with('success', $successMessage);
    }

    public function submit(Request $request)
    {
        $candidate = auth()->user();
        $profile = $candidate->candidateProfile;
        
        if (!$profile) {
            return back()->with('error', 'Please complete your profile first.');
        }

        // Submit for verification
        $profile->update([
            'verification_status' => 'pending',
            'is_public' => false, // Will be set to true after admin approval
        ]);

        return redirect()->route('candidate.dashboard')
            ->with('success', 'Profile submitted for verification. You will be notified once it\'s reviewed.');
    }
}

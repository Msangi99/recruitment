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
            $profile->load(['skills', 'languages']);
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

        return view('candidate.profile.create');
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'date_of_birth' => 'required|date|before:today',
            'citizenship' => 'required|string|max:100',
            'residency_status' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'marital_status' => 'required|in:single,married,divorced,widowed',
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

        // Ensure they are arrays
        if (!is_array($skills)) {
            $skills = [];
        }
        if (!is_array($languages)) {
            $languages = [];
        }

        $validated = $request->validate([
            'education_level' => 'required|string|max:100',
            'years_of_experience' => 'required|integer|min:0|max:50',
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
        $profile->update($validated);

        // Sync skills - create skills if they don't exist
        $skillIds = [];
        foreach ($skills as $skillName) {
            $skill = \App\Models\Skill::firstOrCreate(['name' => trim($skillName)]);
            $skillIds[] = $skill->id;
        }
        $profile->skills()->sync($skillIds);

        // Sync languages - create languages if they don't exist
        $languageIds = [];
        foreach ($languages as $languageName) {
            $language = \App\Models\Language::firstOrCreate(['name' => trim($languageName)]);
            $languageIds[] = $language->id;
        }
        $profile->languages()->sync($languageIds);

        return response()->json(['success' => true, 'step' => 3]);
    }

    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            'expected_salary' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'target_destination' => 'nullable|string|max:255',
            'is_available' => 'boolean',
        ]);

        $candidate = auth()->user();
        $profile = $candidate->candidateProfile;
        
        if (!$profile) {
            return response()->json(['success' => false, 'message' => 'Please complete previous steps first'], 400);
        }

        $validated['is_available'] = $request->has('is_available');
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

        $profile->load(['skills', 'languages']);
        return view('candidate.profile.edit', compact('profile'));
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
            'content_type' => $request->header('Content-Type')
        ]);
        
        if (!$profile) {
            return redirect()->route('candidate.profile.create')
                ->with('error', 'Please create your profile first.');
        }

        // Handle skills and languages - can come as array (skills[]) or JSON string
        $skills = $request->input('skills', []);
        $languages = $request->input('languages', []);
        
        // If skills/languages come as a single JSON string, decode it
        if (is_string($skills) && !empty($skills)) {
            $decoded = json_decode($skills, true);
            $skills = is_array($decoded) ? $decoded : [];
        }
        if (is_string($languages) && !empty($languages)) {
            $decoded = json_decode($languages, true);
            $languages = is_array($decoded) ? $decoded : [];
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
            'date_of_birth' => 'required|date|before:today',
            'citizenship' => 'required|string|max:100',
            'residency_status' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'education_level' => 'required|string|max:100',
            'years_of_experience' => 'required|integer|min:0|max:50',
            'expected_salary' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'target_destination' => 'nullable|string|max:255',
            'is_available' => 'boolean',
        ]);

        // Validate skills and languages separately
        if (empty($skills) || !is_array($skills)) {
            return back()->withErrors(['skills' => 'At least one skill is required.'])->withInput();
        }
        if (empty($languages) || !is_array($languages)) {
            return back()->withErrors(['languages' => 'At least one language is required.'])->withInput();
        }

        // Validate each skill and language
        foreach ($skills as $skill) {
            if (!is_string($skill) || strlen($skill) > 100) {
                return back()->withErrors(['skills' => 'Each skill must be a string with max 100 characters.'])->withInput();
            }
        }
        foreach ($languages as $language) {
            if (!is_string($language) || strlen($language) > 50) {
                return back()->withErrors(['languages' => 'Each language must be a string with max 50 characters.'])->withInput();
            }
        }

        $validated['is_available'] = $request->has('is_available');

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

        // Sync skills - create skills if they don't exist
        $skillIds = [];
        foreach ($skills as $skillName) {
            $skill = \App\Models\Skill::firstOrCreate(['name' => trim($skillName)]);
            $skillIds[] = $skill->id;
        }
        $profile->skills()->sync($skillIds);

        // Sync languages - create languages if they don't exist
        $languageIds = [];
        foreach ($languages as $languageName) {
            $language = \App\Models\Language::firstOrCreate(['name' => trim($languageName)]);
            $languageIds[] = $language->id;
        }
        $profile->languages()->sync($languageIds);

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

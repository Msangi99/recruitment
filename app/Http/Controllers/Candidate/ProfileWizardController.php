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
                break;
            case 4: // Skills
                $viewData['allSkills'] = Skill::orderBy('name')->get();
                // Get existing skills
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
                    'date_of_birth' => 'required|date',
                    'city' => 'required|string|max:255',
                    'country' => 'required|string|max:255',
                ]);
                
                $profile->update([
                    'citizenship' => $validated['citizenship'],
                    'date_of_birth' => $validated['date_of_birth'],
                    'location' => $validated['city'] . ', ' . $validated['country'], // Storing as comma separated for now to match existing
                ]);
                break;

            case 3: // Job Preferences
                $validated = $request->validate([
                    'categories' => 'required|array',
                    'preferred_job_titles' => 'required|string', // Comma separated for now or tags
                    'availability_status' => 'required|string',
                    // employment_type handling if needed (add to model/migration if likely new)
                ]);

                // Map Preferred Job Titles (User input string to array)
                // Assuming it comes as comma separated string from tag input
                $titles = array_map('trim', explode(',', $validated['preferred_job_titles']));
                
                $profile->update([
                    // 'experience_category_id' => $validated['categories'][0] ?? null, // Keep for backward compatibility if needed, or remove
                    'availability_status' => $validated['availability_status'],
                    'preferred_job_titles' => $titles,
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
                ]);

                $profile->update([
                    'headline' => $validated['headline'],
                    'description' => $validated['description'],
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
                    if(!empty($lang['id'])) {
                        $syncData[$lang['id']] = ['proficiency' => $lang['proficiency']];
                    }
                }
                
                $profile->languages()->sync($syncData);
                break;

            case 10: // Compliance & Documents
                 // Check if files are uploaded if they are mandatory (Photo verified in logic below or client side)
                 // Requirement: "Before submit, candidate must tick: I consent..."
                 $validated = $request->validate([
                     'consent' => 'required|accepted',
                 ]);
                 // Proceed to next step
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

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|max:3072', // 3MB
        ]);

        $user = auth()->user();
        $profile = $user->candidateProfile;

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('profile-pictures'), $filename);

            $profile->update(['profile_picture' => $filename]);
            
            return response()->json([
                'success' => true,
                'path' => asset('profile-pictures/' . $filename)
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    public function uploadVideo(Request $request)
    {
         $request->validate([
            'video_cv' => 'required|mimetypes:video/mp4,video/quicktime|max:102400', // 100MB
        ]);

        $user = auth()->user();
        $profile = $user->candidateProfile;

        if ($request->hasFile('video_cv')) {
            $file = $request->file('video_cv');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Unified storage path
            $destinationPath = public_path('uploads/video_cvs');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $filePath = 'uploads/video_cvs/' . $filename;

            $profile->update(['video_cv' => $filename]);

            // Sync with Documents table
            \App\Models\Document::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'document_type' => 'video_cv',
                ],
                [
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'verification_status' => 'pending',
                ]
            );
            
            return response()->json([
                'success' => true,
                'path' => asset($filePath)
            ]);
        }
        
        return response()->json(['success' => false], 400);
    }
}

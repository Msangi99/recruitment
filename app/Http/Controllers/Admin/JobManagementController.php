<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;

class JobManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = JobListing::with(['employer', 'category', 'applications']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Country filter
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Employment Type filter
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        // Status (active/inactive) filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $jobs = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::all();

        return view('admin.jobs.index', compact('jobs', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $skills = Skill::all();
        return view('admin.jobs.create', compact('categories', 'skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'job_location_type' => 'required|string|in:Local,Abroad',
            'employment_type' => 'required|string',
            'contract_duration' => 'nullable|string',
            'working_mode' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_currency' => 'nullable|string',
            'salary_period' => 'nullable|string',
            'experience_years' => 'nullable|integer',
            'education_level' => 'nullable|string',
            'required_skills' => 'nullable|string', // JSON string from hidden input
            'languages' => 'nullable|string', // JSON string from hidden input
            'willing_to_relocate' => 'boolean',
            'required_passport' => 'boolean',
            'medical_clearance' => 'boolean',
            'police_clearance' => 'boolean',
            'benefits' => 'nullable|array',
            'other_benefits' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);

        // Handle custom currency if provided
        if ($request->salary_currency === 'OTHER' && $request->filled('custom_currency')) {
            $validated['salary_currency'] = $request->custom_currency;
        }

        // Parse JSON fields
        if ($request->filled('required_skills')) {
            $validated['required_skills'] = json_decode($request->input('required_skills'), true);
        }
        if ($request->filled('languages')) {
            $validated['languages'] = json_decode($request->input('languages'), true);
        }

        // Admin posts jobs without employer_id (system jobs)
        $validated['employer_id'] = null;
        $validated['is_active'] = !$request->has('is_draft');
        $validated['status'] = $validated['is_active'] ? 'open' : 'open'; // You might want a 'draft' status in DB

        JobListing::create($validated);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job posted successfully.');
    }

    public function show(JobListing $job)
    {
        $job->load(['employer', 'category', 'applications.candidate']);
        return view('admin.jobs.show', compact('job'));
    }

    public function edit(JobListing $job)
    {
        $categories = Category::all();
        $skills = Skill::all();
        return view('admin.jobs.edit', compact('job', 'categories', 'skills'));
    }

    public function update(Request $request, JobListing $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'job_location_type' => 'required|string|in:Local,Abroad',
            'employment_type' => 'required|string',
            'contract_duration' => 'nullable|string',
            'working_mode' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_currency' => 'nullable|string',
            'salary_period' => 'nullable|string',
            'experience_years' => 'nullable|integer',
            'education_level' => 'nullable|string',
            'required_skills' => 'nullable|string', // JSON string from hidden input
            'languages' => 'nullable|string', // JSON string from hidden input
            'willing_to_relocate' => 'boolean',
            'required_passport' => 'boolean',
            'medical_clearance' => 'boolean',
            'police_clearance' => 'boolean',
            'benefits' => 'nullable|array',
            'other_benefits' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);

        // Handle custom currency if provided
        if ($request->salary_currency === 'OTHER' && $request->filled('custom_currency')) {
            $validated['salary_currency'] = $request->custom_currency;
        }

        // Parse JSON fields
        if ($request->filled('required_skills')) {
            $validated['required_skills'] = json_decode($request->input('required_skills'), true);
        }
        if ($request->filled('languages')) {
            $validated['languages'] = json_decode($request->input('languages'), true);
        }

        $validated['is_active'] = !$request->has('is_draft');

        $job->update($validated);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    public function destroy(JobListing $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }

    public function toggleStatus(JobListing $job)
    {
        $job->update(['is_active' => !$job->is_active]);
        return back()->with('success', 'Job status updated.');
    }

    public function updateApplicationStatus(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,interview,offered,rejected,withdrawn',
        ]);

        $application->update(['status' => $validated['status']]);

        return back()->with('success', 'Application status updated to ' . ucfirst($validated['status']) . '.');
    }
}

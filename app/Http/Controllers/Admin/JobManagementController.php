<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Category;
use Illuminate\Http\Request;

class JobManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = JobListing::with(['employer', 'category', 'applications']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $jobs = $query->latest()->paginate(20);
        $categories = Category::all();

        return view('admin.jobs.index', compact('jobs', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'employment_type' => 'required|string',
            'work_hours' => 'nullable|string',
            'education_level' => 'nullable|string',
            'experience_required' => 'nullable|string',
            'languages' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_currency' => 'nullable|string|max:10',
            'salary_period' => 'nullable|string|max:20',
            'positions_available' => 'nullable|integer|min:1',
            'application_deadline' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        // Admin posts jobs without employer_id (system jobs)
        $validated['employer_id'] = null;
        $validated['is_active'] = $request->has('is_active');

        // Ensure languages is saved as an array for JsonContains search
        if ($request->filled('languages')) {
            $validated['languages'] = (array) $request->input('languages');
        }

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
        return view('admin.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, JobListing $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'employment_type' => 'required|string',
            'work_hours' => 'nullable|string',
            'education_level' => 'nullable|string',
            'experience_required' => 'nullable|string',
            'languages' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_currency' => 'nullable|string|max:10',
            'salary_period' => 'nullable|string|max:20',
            'positions_available' => 'nullable|integer|min:1',
            'application_deadline' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Ensure languages is saved as an array for JsonContains search
        if ($request->filled('languages')) {
            $validated['languages'] = (array) $request->input('languages');
        }

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

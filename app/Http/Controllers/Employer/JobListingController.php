<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\Category;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $employer = auth()->user();
        
        $query = JobListing::where('employer_id', $employer->id)
            ->with(['category', 'applications']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $jobs = $query->latest()->paginate(20);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('employer.jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'employment_type' => 'required|string',
            'education_level' => 'nullable|string',
            'experience_required' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_currency' => 'nullable|string|max:10',
            'positions_available' => 'nullable|integer|min:1',
            'application_deadline' => 'nullable|date',
            'is_active' => 'boolean',
            'requires_video' => 'boolean',
        ]);

        $validated['employer_id'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');
        $validated['requires_video'] = $request->has('requires_video');

        JobListing::create($validated);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job posted successfully.');
    }

    public function show(JobListing $job)
    {
        if ($job->employer_id !== auth()->id()) {
            abort(403);
        }

        $job->load(['category', 'applications.candidate']);
        return view('employer.jobs.show', compact('job'));
    }

    public function edit(JobListing $job)
    {
        if ($job->employer_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('employer.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, JobListing $job)
    {
        if ($job->employer_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'employment_type' => 'required|string',
            'education_level' => 'nullable|string',
            'experience_required' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_currency' => 'nullable|string|max:10',
            'positions_available' => 'nullable|integer|min:1',
            'application_deadline' => 'nullable|date',
            'is_active' => 'boolean',
            'requires_video' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['requires_video'] = $request->has('requires_video');
        $job->update($validated);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    public function destroy(JobListing $job)
    {
        if ($job->employer_id !== auth()->id()) {
            abort(403);
        }

        $job->delete();
        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }

    public function toggleStatus(JobListing $job)
    {
        if ($job->employer_id !== auth()->id()) {
            abort(403);
        }

        $job->update(['is_active' => !$job->is_active]);
        return back()->with('success', 'Job status updated.');
    }
}

<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Category;
use Illuminate\Http\Request;

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

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        $jobs = $query->latest()->paginate(20);
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

        $validated = $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
        ]);

        JobApplication::create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'cover_letter' => $validated['cover_letter'] ?? null,
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
}

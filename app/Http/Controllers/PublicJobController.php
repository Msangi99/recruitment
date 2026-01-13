<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicJobController extends Controller
{
    public function index(Request $request)
    {
        $query = JobListing::where('is_active', true)
            ->with(['category']);

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

        // Country filter
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

        // Experience level filter
        if ($request->filled('experience_level')) {
            switch ($request->experience_level) {
                case 'no-experience':
                    $query->where('experience_required', 0);
                    break;
                case '0-1':
                    $query->whereBetween('experience_required', [0, 1]);
                    break;
                case '1-3':
                    $query->whereBetween('experience_required', [1, 3]);
                    break;
                case '3+':
                    $query->where('experience_required', '>=', 3);
                    break;
            }
        }

        // Education level filter
        if ($request->filled('education_level')) {
            $query->where('education_level', $request->education_level);
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

        // Salary period filter
        if ($request->filled('salary_period')) {
            $query->where('salary_period', $request->salary_period);
        }

        // Salary range filter
        if ($request->filled('min_salary')) {
            $query->where(function($q) use ($request) {
                $q->where('salary_min', '>=', $request->min_salary)
                  ->orWhere('salary_max', '>=', $request->min_salary);
            });
        }
        if ($request->filled('max_salary')) {
            $query->where(function($q) use ($request) {
                $q->where('salary_min', '<=', $request->max_salary)
                  ->orWhere('salary_max', '<=', $request->max_salary);
            });
        }

        // Date posted filter
        if ($request->filled('date_posted')) {
            switch ($request->date_posted) {
                case '24-hours':
                    $query->where('created_at', '>=', now()->subDay());
                    break;
                case '3-days':
                    $query->where('created_at', '>=', now()->subDays(3));
                    break;
                case '7-days':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case '14-days':
                    $query->where('created_at', '>=', now()->subDays(14));
                    break;
            }
        }

        $jobs = $query->latest()->paginate(20);
        $categories = Category::where('is_active', true)->get();

        return view('public.jobs.index', compact('jobs', 'categories'));
    }

    public function show(JobListing $job)
    {
        if (!$job->is_active) {
            abort(404);
        }

        $job->load(['category']);

        // Check if user is logged in and is a candidate
        $hasApplied = false;
        $isCandidate = false;
        
        if (auth()->check() && auth()->user()->role === 'candidate') {
            $isCandidate = true;
            $hasApplied = \App\Models\JobApplication::where('candidate_id', auth()->id())
                ->where('job_id', $job->id)
                ->exists();
        }

        return view('public.jobs.show', compact('job', 'hasApplied', 'isCandidate'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Job Category filter (by name - used in public view)
        if ($request->filled('job_category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->job_category);
            });
        }

        // Category filter (by ID - backward compatibility)
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
            $query->where('industry', $request->industry);
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

        // Salary period filter
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

        $jobs = $query->latest()->paginate(10)->withQueryString();
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

<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Appointment;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function dashboard()
    {
        $employer = auth()->user();

        $stats = [
            'total_jobs' => JobListing::where('employer_id', $employer->id)->count(),
            'active_jobs' => JobListing::where('employer_id', $employer->id)->where('is_active', true)->count(),
            'total_applications' => JobApplication::whereHas('job', function($q) use ($employer) {
                $q->where('employer_id', $employer->id);
            })->count(),
            'pending_applications' => JobApplication::whereHas('job', function($q) use ($employer) {
                $q->where('employer_id', $employer->id);
            })->where('status', 'pending')->count(),
            'pending_interviews' => Appointment::where('employer_id', $employer->id)
                ->where('appointment_type', 'interview')
                ->where('status', 'pending')
                ->count(),
            'total_interviews' => Appointment::where('employer_id', $employer->id)
                ->where('appointment_type', 'interview')
                ->count(),
        ];

        $recentJobs = JobListing::where('employer_id', $employer->id)
            ->with('applications')
            ->latest()
            ->take(5)
            ->get();

        $recentApplications = JobApplication::whereHas('job', function($q) use ($employer) {
            $q->where('employer_id', $employer->id);
        })
        ->with(['job', 'candidate'])
        ->latest()
        ->take(5)
        ->get();

        return view('employer.dashboard', compact('stats', 'recentJobs', 'recentApplications'));
    }
}

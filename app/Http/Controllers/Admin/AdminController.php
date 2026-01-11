<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\JobListing;
use App\Models\Appointment;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistics
        $stats = [
            'total_users' => User::count(),
            'total_candidates' => User::where('role', 'candidate')->count(),
            'total_employers' => User::where('role', 'employer')->count(),
            'pending_verifications' => CandidateProfile::where('verification_status', 'pending')->count(),
            'verified_candidates' => CandidateProfile::where('verification_status', 'approved')->count(),
            'total_jobs' => JobListing::count(),
            'active_jobs' => JobListing::where('is_active', true)->count(),
            'total_applications' => JobApplication::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'total_appointments' => Appointment::count(),
            'total_revenue' => Appointment::where('payment_status', 'completed')->sum('amount'),
        ];

        // Recent activities
        $recentCandidates = User::where('role', 'candidate')
            ->with('candidateProfile')
            ->latest()
            ->take(5)
            ->get();

        $pendingVerifications = CandidateProfile::where('verification_status', 'pending')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        $recentJobs = JobListing::with(['employer', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recentAppointments = Appointment::with(['user', 'employer'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentCandidates',
            'pendingVerifications',
            'recentJobs',
            'recentAppointments'
        ));
    }
}

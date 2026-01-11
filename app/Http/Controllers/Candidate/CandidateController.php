<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Appointment;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function dashboard()
    {
        $candidate = auth()->user();

        $stats = [
            'total_applications' => JobApplication::where('candidate_id', $candidate->id)->count(),
            'pending_applications' => JobApplication::where('candidate_id', $candidate->id)->where('status', 'pending')->count(),
            'shortlisted_applications' => JobApplication::where('candidate_id', $candidate->id)->whereIn('status', ['shortlisted', 'interview', 'offered'])->count(),
            'profile_complete' => $candidate->candidateProfile ? true : false,
            'profile_verified' => $candidate->candidateProfile && $candidate->candidateProfile->verification_status === 'approved',
            'total_consultations' => Appointment::where('user_id', $candidate->id)->where('appointment_type', 'consultation')->count(),
        ];

        $recentApplications = JobApplication::where('candidate_id', $candidate->id)
            ->with('job')
            ->latest()
            ->take(5)
            ->get();

        $upcomingAppointments = Appointment::where('user_id', $candidate->id)
            ->where('status', 'confirmed')
            ->where('scheduled_at', '>=', now())
            ->latest('scheduled_at')
            ->take(5)
            ->get();

        return view('candidate.dashboard', compact('stats', 'recentApplications', 'upcomingAppointments'));
    }
}

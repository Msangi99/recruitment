<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConsultationStatusUpdated;
use App\Services\NotificationMailService;

class ConsultationRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ConsultationRequest::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $consultations = $query->latest()->paginate(20);
        return view('admin.consultations.index', compact('consultations'));
    }

    public function show($id)
    {
        $consultation = ConsultationRequest::findOrFail($id);
        return view('admin.consultations.show', compact('consultation'));
    }

    public function updateStatus(Request $request, $id)
    {
        $consultation = ConsultationRequest::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled,pending_review',
        ]);

        $previousStatus = $consultation->status;
        $consultation->update(['status' => $request->status]);

        if ($previousStatus !== $request->status && $consultation->email) {
            NotificationMailService::sendIfEnabled(function () use ($consultation) {
                Mail::to($consultation->email)->send(new ConsultationStatusUpdated($consultation));
            }, 'consultation_status_updated');
        }

        return back()->with('success', 'Status updated successfully.');
    }
}

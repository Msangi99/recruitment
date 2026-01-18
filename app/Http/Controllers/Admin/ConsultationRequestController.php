<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use Illuminate\Http\Request;

class ConsultationRequestController extends Controller
{
    public function index()
    {
        $consultations = ConsultationRequest::latest()->paginate(20);
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

        $consultation->update(['status' => $request->status]);

        // Optional: Send email notification on status change

        return back()->with('success', 'Status updated successfully.');
    }
}

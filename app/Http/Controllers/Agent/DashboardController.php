<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $assignedDevices = $user->assignedDevices()->latest('assigned_at')->get();

        return view('agent.dashboard', compact('user', 'assignedDevices'));
    }
}

<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use App\Services\DeviceAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function __construct(private DeviceAssignmentService $deviceAssignmentService)
    {
    }

    public function index()
    {
        $user = auth()->user();

        $assignedDevices = $user->assignedDevices()->latest('assigned_at')->get();
        $agents = $user->subordinates()
            ->where('role', 'agent')
            ->withCount('assignedDevices')
            ->orderBy('name')
            ->get();

        $assignableDevices = $this->deviceAssignmentService->assignableDevicesFor($user);

        return view('team-leader.dashboard', compact('user', 'assignedDevices', 'agents', 'assignableDevices'));
    }

    public function storeAgent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'agent',
            'supervisor_id' => auth()->id(),
            'is_active' => true,
        ]);

        return back()->with('success', 'Agent created successfully.');
    }

    public function assignDevice(Request $request, User $agent)
    {
        abort_unless($agent->role === 'agent' && $agent->supervisor_id === auth()->id(), 404);

        $validated = $request->validate([
            'device_id' => ['required', Rule::exists('devices', 'id')],
        ]);

        $device = Device::findOrFail($validated['device_id']);

        $this->deviceAssignmentService->assign($device, $agent, auth()->user());

        return back()->with('success', 'Device assigned to agent successfully.');
    }
}

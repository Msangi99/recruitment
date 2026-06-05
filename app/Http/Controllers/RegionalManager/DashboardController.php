<?php

namespace App\Http\Controllers\RegionalManager;

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
        $teamLeaders = $user->subordinates()
            ->where('role', 'team_leader')
            ->withCount('assignedDevices')
            ->orderBy('name')
            ->get();

        return view('regional-manager.dashboard', compact('user', 'assignedDevices', 'teamLeaders'));
    }

    public function storeTeamLeader(Request $request)
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
            'role' => 'team_leader',
            'supervisor_id' => auth()->id(),
            'is_active' => true,
        ]);

        return back()->with('success', 'Team leader created successfully.');
    }

    public function showTeamLeader(User $teamLeader)
    {
        abort_unless($teamLeader->role === 'team_leader' && $teamLeader->supervisor_id === auth()->id(), 404);

        $teamLeader->load(['assignedDevices', 'subordinates.assignedDevices']);

        $assignableDevices = $this->deviceAssignmentService->assignableDevicesFor(auth()->user());

        $agents = $teamLeader->subordinates()
            ->where('role', 'agent')
            ->withCount('assignedDevices')
            ->orderBy('name')
            ->get();

        return view('regional-manager.team-leaders.show', compact('teamLeader', 'assignableDevices', 'agents'));
    }

    public function assignDevice(Request $request, User $teamLeader)
    {
        abort_unless($teamLeader->role === 'team_leader' && $teamLeader->supervisor_id === auth()->id(), 404);

        $validated = $request->validate([
            'device_id' => ['required', Rule::exists('devices', 'id')],
        ]);

        $device = Device::findOrFail($validated['device_id']);

        $this->deviceAssignmentService->assign($device, $teamLeader, auth()->user());

        return back()->with('success', 'Device assigned to team leader successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use App\Services\DeviceAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegionalManagerController extends Controller
{
    public function __construct(private DeviceAssignmentService $deviceAssignmentService)
    {
    }

    public function index()
    {
        $regionalManagers = User::query()
            ->where('role', 'regional_manager')
            ->withCount(['assignedDevices', 'subordinates'])
            ->latest()
            ->paginate(20);

        return view('admin.regional-managers.index', compact('regionalManagers'));
    }

    public function create()
    {
        return view('admin.regional-managers.create');
    }

    public function store(Request $request)
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
            'role' => 'regional_manager',
            'is_active' => true,
        ]);

        return redirect()->route('admin.regional-managers.index')
            ->with('success', 'Regional manager created successfully.');
    }

    public function show(User $regionalManager)
    {
        abort_unless($regionalManager->role === 'regional_manager', 404);

        $regionalManager->load(['assignedDevices', 'subordinates.assignedDevices']);

        $availableDevices = $this->deviceAssignmentService->assignableDevicesFor(auth()->user());
        $teamLeaders = $regionalManager->subordinates()
            ->where('role', 'team_leader')
            ->withCount('assignedDevices')
            ->orderBy('name')
            ->get();

        return view('admin.regional-managers.show', compact('regionalManager', 'availableDevices', 'teamLeaders'));
    }

    public function storeTeamLeader(Request $request, User $regionalManager)
    {
        abort_unless($regionalManager->role === 'regional_manager', 404);

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
            'supervisor_id' => $regionalManager->id,
            'is_active' => true,
        ]);

        return back()->with('success', 'Team leader added successfully.');
    }

    public function assignDevice(Request $request, User $regionalManager)
    {
        abort_unless($regionalManager->role === 'regional_manager', 404);

        $validated = $request->validate([
            'device_id' => ['required', Rule::exists('devices', 'id')],
        ]);

        $device = Device::findOrFail($validated['device_id']);

        $this->deviceAssignmentService->assign($device, $regionalManager, auth()->user());

        return back()->with('success', 'Device assigned to regional manager successfully.');
    }
}

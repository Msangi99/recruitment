<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Services\DeviceAssignmentService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function __construct(private DeviceAssignmentService $deviceAssignmentService)
    {
    }

    public function index()
    {
        $devices = Device::with(['assignedTo', 'assignedBy'])
            ->latest()
            ->paginate(20);

        return view('admin.devices.index', compact('devices'));
    }

    public function create()
    {
        return view('admin.devices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'device_code' => 'required|string|max:255|unique:devices,device_code',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        Device::create([
            ...$validated,
            'status' => 'available',
        ]);

        return redirect()->route('admin.devices.index')
            ->with('success', 'Device registered successfully.');
    }

    public function unassign(Device $device)
    {
        $this->deviceAssignmentService->unassign($device, auth()->user());

        return back()->with('success', 'Device unassigned and returned to inventory.');
    }
}

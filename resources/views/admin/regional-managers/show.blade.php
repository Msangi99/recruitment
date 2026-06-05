@extends('layouts.admin')

@section('title', $regionalManager->name)

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.regional-managers.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Regional Managers</a>
        <h2 class="text-2xl font-bold text-gray-900 mt-2">{{ $regionalManager->name }}</h2>
        <p class="text-sm text-gray-500">{{ $regionalManager->email }} · {{ $regionalManager->phone ?? 'No phone' }}</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Assign Device</h3>
        @if($availableDevices->isEmpty())
            <p class="text-sm text-gray-500 mb-3">No available devices. <a href="{{ route('admin.devices.create') }}" class="text-blue-600 hover:underline">Register a device</a> first.</p>
        @else
            @include('partials.assign-device-form', [
                'action' => route('admin.regional-managers.assign-device', $regionalManager),
                'devices' => $availableDevices,
                'assigneeLabel' => 'Assign to Regional Manager',
            ])
        @endif
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Assigned Devices</h3>
        </div>
        @if($regionalManager->assignedDevices->isEmpty())
            <p class="px-6 py-8 text-gray-500 text-sm">No devices assigned yet.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Device</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Assigned</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($regionalManager->assignedDevices as $device)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $device->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $device->device_code }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $device->assigned_at?->format('M d, Y H:i') ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Add Team Leader</h3>
            <form method="POST" action="{{ route('admin.regional-managers.team-leaders.store', $regionalManager) }}" class="space-y-3">
                @csrf
                <input type="text" name="name" placeholder="Full name" required class="w-full rounded-lg border p-3 border-gray-300">
                <input type="email" name="email" placeholder="Email" required class="w-full rounded-lg border p-3 border-gray-300">
                <input type="text" name="phone" placeholder="Phone (optional)" class="w-full rounded-lg border p-3 border-gray-300">
                <input type="password" name="password" placeholder="Password" required class="w-full rounded-lg border p-3 border-gray-300">
                <input type="password" name="password_confirmation" placeholder="Confirm password" required class="w-full rounded-lg border p-3 border-gray-300">
                <button type="submit" class="w-full py-2.5 bg-emerald-700 text-white font-bold rounded-lg">Add Team Leader</button>
            </form>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900">Team Leaders</h3>
            </div>
            @if($teamLeaders->isEmpty())
                <p class="px-6 py-8 text-gray-500 text-sm">No team leaders under this regional manager.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($teamLeaders as $leader)
                        <li class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-gray-900">{{ $leader->name }}</p>
                                <p class="text-sm text-gray-500">{{ $leader->email }} · {{ $leader->assigned_devices_count }} device(s)</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

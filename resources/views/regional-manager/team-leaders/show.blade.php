@extends('layouts.staff', ['portalLabel' => 'Regional Manager'])

@section('title', $teamLeader->name)

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('regional-manager.dashboard') }}" class="text-sm text-emerald-700 hover:underline">&larr; Back to Dashboard</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $teamLeader->name }}</h1>
        <p class="text-sm text-gray-500">{{ $teamLeader->email }}</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <h2 class="text-lg font-bold mb-4">Assign Device to Team Leader</h2>
        @if($assignableDevices->isEmpty())
            <p class="text-sm text-gray-500">You have no devices available to assign. Devices must be assigned to you by admin first.</p>
        @else
            @include('partials.assign-device-form', [
                'action' => route('regional-manager.team-leaders.assign-device', $teamLeader),
                'devices' => $assignableDevices,
                'assigneeLabel' => 'Assign to Team Leader',
            ])
        @endif
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-lg font-bold">Devices Assigned to {{ $teamLeader->name }}</h2>
        </div>
        @if($teamLeader->assignedDevices->isEmpty())
            <p class="px-6 py-8 text-sm text-gray-500">No devices assigned yet.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($teamLeader->assignedDevices as $device)
                    <li class="px-6 py-4 text-sm">
                        <span class="font-medium">{{ $device->name }}</span>
                        <span class="text-gray-500">({{ $device->device_code }})</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    @if($agents->isNotEmpty())
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="text-lg font-bold">Agents under this Team Leader</h2>
            </div>
            <ul class="divide-y divide-gray-200">
                @foreach($agents as $agent)
                    <li class="px-6 py-4 text-sm flex justify-between">
                        <span>{{ $agent->name }} ({{ $agent->email }})</span>
                        <span class="text-gray-500">{{ $agent->assigned_devices_count }} device(s)</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection

@extends('layouts.staff', ['portalLabel' => 'Team Leader'])

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Team Leader Dashboard</h1>
        <p class="text-sm text-gray-500">Assign devices to your agents</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <h2 class="text-lg font-bold mb-4">My Devices ({{ $assignedDevices->count() }})</h2>
        @if($assignedDevices->isEmpty())
            <p class="text-sm text-gray-500">No devices assigned to you yet. Ask your regional manager.</p>
        @else
            <ul class="divide-y divide-gray-100">
                @foreach($assignedDevices as $device)
                    <li class="py-3 text-sm font-medium">{{ $device->name }} ({{ $device->device_code }})</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-lg font-bold mb-4">Add Agent</h2>
            <form method="POST" action="{{ route('team-leader.agents.store') }}" class="space-y-3">
                @csrf
                <input type="text" name="name" placeholder="Full name" required class="w-full rounded-lg border p-3 border-gray-300">
                <input type="email" name="email" placeholder="Email" required class="w-full rounded-lg border p-3 border-gray-300">
                <input type="text" name="phone" placeholder="Phone (optional)" class="w-full rounded-lg border p-3 border-gray-300">
                <input type="password" name="password" placeholder="Password" required class="w-full rounded-lg border p-3 border-gray-300">
                <input type="password" name="password_confirmation" placeholder="Confirm password" required class="w-full rounded-lg border p-3 border-gray-300">
                <button type="submit" class="w-full py-2.5 bg-emerald-700 text-white font-bold rounded-lg">Create Agent</button>
            </form>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="text-lg font-bold">Agents</h2>
            </div>
            @if($agents->isEmpty())
                <p class="px-6 py-8 text-sm text-gray-500">No agents yet.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($agents as $agent)
                        <li class="px-6 py-4 space-y-3">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <p class="font-bold text-gray-900">{{ $agent->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $agent->email }} · {{ $agent->assigned_devices_count }} device(s)</p>
                                </div>
                            </div>
                            @if($assignableDevices->isNotEmpty())
                                @include('partials.assign-device-form', [
                                    'action' => route('team-leader.agents.assign-device', $agent),
                                    'devices' => $assignableDevices,
                                    'assigneeLabel' => 'Assign to Agent',
                                ])
                            @else
                                <p class="text-xs text-gray-500">No devices available to assign.</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

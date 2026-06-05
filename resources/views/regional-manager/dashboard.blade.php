@extends('layouts.staff', ['portalLabel' => 'Regional Manager'])

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Regional Manager Dashboard</h1>
        <p class="text-sm text-gray-500">Assign devices to your team leaders</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <h2 class="text-lg font-bold mb-4">My Devices ({{ $assignedDevices->count() }})</h2>
        @if($assignedDevices->isEmpty())
            <p class="text-sm text-gray-500">No devices assigned to you yet. Contact admin.</p>
        @else
            <ul class="divide-y divide-gray-100">
                @foreach($assignedDevices as $device)
                    <li class="py-3 flex justify-between text-sm">
                        <span class="font-medium">{{ $device->name }} <span class="text-gray-500">({{ $device->device_code }})</span></span>
                        <span class="text-gray-500">{{ $device->assigned_at?->format('M d, Y') }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-lg font-bold mb-4">Add Team Leader</h2>
            <form method="POST" action="{{ route('regional-manager.team-leaders.store') }}" class="space-y-3">
                @csrf
                <input type="text" name="name" placeholder="Full name" required class="w-full rounded-lg border p-3 border-gray-300">
                <input type="email" name="email" placeholder="Email" required class="w-full rounded-lg border p-3 border-gray-300">
                <input type="text" name="phone" placeholder="Phone (optional)" class="w-full rounded-lg border p-3 border-gray-300">
                <input type="password" name="password" placeholder="Password" required class="w-full rounded-lg border p-3 border-gray-300">
                <input type="password" name="password_confirmation" placeholder="Confirm password" required class="w-full rounded-lg border p-3 border-gray-300">
                <button type="submit" class="w-full py-2.5 bg-emerald-700 text-white font-bold rounded-lg">Create Team Leader</button>
            </form>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="text-lg font-bold">Team Leaders</h2>
            </div>
            @if($teamLeaders->isEmpty())
                <p class="px-6 py-8 text-sm text-gray-500">No team leaders yet.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($teamLeaders as $leader)
                        <li class="px-6 py-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-bold text-gray-900">{{ $leader->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $leader->email }} · {{ $leader->assigned_devices_count }} device(s)</p>
                                </div>
                                <a href="{{ route('regional-manager.team-leaders.show', $leader) }}" class="text-sm font-bold text-emerald-700 hover:underline whitespace-nowrap">
                                    Assign Device
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

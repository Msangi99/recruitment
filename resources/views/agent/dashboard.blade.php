@extends('layouts.staff', ['portalLabel' => 'Agent'])

@section('title', 'My Devices')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Welcome, {{ $user->name }}</h1>
        <p class="text-sm text-gray-500">Devices assigned to you</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        @if($assignedDevices->isEmpty())
            <p class="px-6 py-12 text-center text-gray-500">No devices assigned yet.</p>
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
                    @foreach($assignedDevices as $device)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $device->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $device->device_code }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $device->assigned_at?->format('M d, Y') ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

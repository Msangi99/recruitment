@extends('layouts.admin')

@section('title', 'Devices')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Devices</h2>
            <p class="text-sm text-gray-500">Register and manage field devices</p>
        </div>
        <a href="{{ route('admin.devices.create') }}" class="px-6 py-2 fb-blue-bg text-white font-bold rounded-xl flex items-center justify-center">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Register Device
        </a>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Device</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Assigned To</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($devices as $device)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $device->name }}</div>
                            <div class="text-xs text-gray-500">{{ $device->brand }} {{ $device->model }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $device->device_code }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-bold rounded-full {{ $device->status === 'available' ? 'bg-green-100 text-green-700' : ($device->status === 'assigned' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                {{ ucfirst($device->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $device->assignedTo?->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($device->assigned_to_user_id)
                                <form method="POST" action="{{ route('admin.devices.unassign', $device) }}" class="inline" onsubmit="return confirm('Return this device to inventory?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-600 text-sm font-bold hover:underline">Unassign</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">No devices registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($devices->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t">{{ $devices->links() }}</div>
        @endif
    </div>
</div>
@endsection

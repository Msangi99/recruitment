@extends('layouts.admin')

@section('title', 'Regional Managers')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Regional Managers</h2>
            <p class="text-sm text-gray-500">Manage regional managers and assign devices</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.devices.index') }}" class="px-5 py-2 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50">
                Devices
            </a>
            <a href="{{ route('admin.regional-managers.create') }}" class="px-6 py-2 fb-blue-bg text-white font-bold rounded-xl hover:bg-blue-600 flex items-center">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Add Regional Manager
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Devices</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Team Leaders</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($regionalManagers as $manager)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $manager->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div>{{ $manager->email }}</div>
                            <div>{{ $manager->phone ?? '—' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">{{ $manager->assigned_devices_count }}</td>
                        <td class="px-6 py-4 text-sm font-medium">{{ $manager->subordinates_count }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.regional-managers.show', $manager) }}" class="fb-blue font-bold text-sm hover:underline">
                                View & Assign Device
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">No regional managers yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($regionalManagers->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t">{{ $regionalManagers->links() }}</div>
        @endif
    </div>
</div>
@endsection

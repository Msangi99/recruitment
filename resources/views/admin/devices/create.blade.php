@extends('layouts.admin')

@section('title', 'Register Device')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.devices.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Devices</a>
        <h2 class="text-2xl font-bold text-gray-900 mt-2">Register Device</h2>
    </div>

    <form method="POST" action="{{ route('admin.devices.store') }}" class="bg-white border border-gray-200 rounded-xl p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Device Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Field Tablet 01" class="w-full rounded-lg border-gray-300 p-3 border">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Device Code / Serial / IMEI</label>
            <input type="text" name="device_code" value="{{ old('device_code') }}" required class="w-full rounded-lg border-gray-300 p-3 border">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                <input type="text" name="brand" value="{{ old('brand') }}" class="w-full rounded-lg border-gray-300 p-3 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                <input type="text" name="model" value="{{ old('model') }}" class="w-full rounded-lg border-gray-300 p-3 border">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 p-3 border">{{ old('notes') }}</textarea>
        </div>
        <button type="submit" class="w-full py-3 fb-blue-bg text-white font-bold rounded-xl">Register Device</button>
    </form>
</div>
@endsection

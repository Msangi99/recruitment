@extends('layouts.admin')

@section('title', 'Add Regional Manager')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.regional-managers.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Regional Managers</a>
        <h2 class="text-2xl font-bold text-gray-900 mt-2">Add Regional Manager</h2>
    </div>

    <form method="POST" action="{{ route('admin.regional-managers.store') }}" class="bg-white border border-gray-200 rounded-xl p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 p-3 border">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border-gray-300 p-3 border">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border-gray-300 p-3 border">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required class="w-full rounded-lg border-gray-300 p-3 border">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full rounded-lg border-gray-300 p-3 border">
        </div>
        <button type="submit" class="w-full py-3 fb-blue-bg text-white font-bold rounded-xl">Create Regional Manager</button>
    </form>
</div>
@endsection

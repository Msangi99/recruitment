@props(['action', 'devices', 'assigneeLabel' => 'Assign to'])

<form method="POST" action="{{ $action }}" class="flex flex-col sm:flex-row gap-3 items-end bg-slate-50 border border-slate-200 rounded-xl p-4">
    @csrf
    <div class="flex-1 w-full">
        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1.5">Select Device</label>
        <select name="device_id" required class="w-full rounded-lg border-gray-300 shadow-sm p-2.5 text-sm border bg-white">
            <option value="">Choose a device...</option>
            @foreach($devices as $device)
                <option value="{{ $device->id }}">
                    {{ $device->name }} ({{ $device->device_code }})
                    @if($device->assignedTo)
                        — currently with {{ $device->assignedTo->name }}
                    @endif
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-bold rounded-lg whitespace-nowrap">
        {{ $assigneeLabel }}
    </button>
</form>

@extends('layouts.admin')

@section('title', 'Commands')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900">System Commands</h2>
        <p class="text-sm text-gray-500 mt-1">Run migration and maintenance commands from admin panel.</p>

        <form method="POST" action="{{ route('admin.commands.run') }}" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div class="md:col-span-2">
                <label for="command" class="block text-sm font-semibold text-gray-700 mb-2">Command</label>
                <select id="command" name="command" required class="w-full rounded-lg border-gray-300">
                    <option value="">Select command</option>
                    @foreach($availableCommands as $command)
                        <option value="{{ $command['value'] }}" {{ old('command') === $command['value'] ? 'selected' : '' }}>
                            {{ $command['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2" id="migration-wrapper">
                <label for="migration" class="block text-sm font-semibold text-gray-700 mb-2">Select Migration (Select2)</label>
                <select id="migration" name="migration" class="w-full rounded-lg border-gray-300">
                    <option value="">Choose migration file</option>
                    @foreach($migrationStatus as $migration)
                        <option value="{{ $migration['name'] }}" {{ old('migration') === $migration['name'] ? 'selected' : '' }}>
                            {{ $migration['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2" id="rollback-wrapper">
                <label for="rollback_step" class="block text-sm font-semibold text-gray-700 mb-2">Rollback Step</label>
                <input type="number" min="1" max="50" id="rollback_step" name="rollback_step" value="{{ old('rollback_step', 1) }}" class="w-full md:w-64 rounded-lg border-gray-300" />
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">
                    Run Command
                </button>
            </div>
        </form>
    </div>

    @if(session('command_output'))
        <div class="bg-slate-900 text-green-300 rounded-xl p-4 border border-slate-700">
            <div class="text-xs uppercase tracking-wide text-slate-400 mb-2">Command Output</div>
            <pre class="text-sm whitespace-pre-wrap">{{ session('command_output') }}</pre>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-900">Migration Files</h3>
        <p class="text-sm text-gray-500 mt-1">All installed and pending migrations.</p>

        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Migration</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Batch</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($migrationStatus as $migration)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $migration['name'] }}</td>
                            <td class="px-4 py-2">
                                @if($migration['installed'])
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-700">Installed</span>
                                @else
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-semibold bg-yellow-100 text-yellow-700">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $migration['batch'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-sm text-gray-500">No migration files found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#migration').select2({
            placeholder: 'Select migration file',
            width: '100%'
        });

        const commandEl = document.getElementById('command');
        const migrationWrapper = document.getElementById('migration-wrapper');
        const rollbackWrapper = document.getElementById('rollback-wrapper');

        function toggleFields() {
            const command = commandEl.value;
            migrationWrapper.style.display = command === 'migrate_selected' ? 'block' : 'none';
            rollbackWrapper.style.display = command === 'migrate_rollback_step' ? 'block' : 'none';
        }

        commandEl.addEventListener('change', toggleFields);
        toggleFields();
    });
</script>
@endpush

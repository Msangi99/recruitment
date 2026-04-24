<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CommandController extends Controller
{
    public function index()
    {
        $migrationFiles = collect(glob(database_path('migrations/*.php')) ?: [])
            ->map(fn($path) => basename($path, '.php'))
            ->sort()
            ->values();

        $installedMigrations = Schema::hasTable('migrations')
            ? DB::table('migrations')->orderByDesc('batch')->orderBy('migration')->get()
            : collect();

        $installedLookup = $installedMigrations->pluck('batch', 'migration');

        $migrationStatus = $migrationFiles->map(function ($migration) use ($installedLookup) {
            return [
                'name' => $migration,
                'installed' => $installedLookup->has($migration),
                'batch' => $installedLookup[$migration] ?? null,
            ];
        });

        return view('admin.commands.index', [
            'migrationStatus' => $migrationStatus,
            'installedMigrations' => $installedMigrations,
            'availableCommands' => $this->availableCommands(),
        ]);
    }

    public function run(Request $request)
    {
        $validated = $request->validate([
            'command' => 'required|string',
            'migration' => 'nullable|string',
            'rollback_step' => 'nullable|integer|min:1|max:50',
        ]);

        $command = $validated['command'];
        $allowedCommands = collect($this->availableCommands())->pluck('value');

        if (!$allowedCommands->contains($command)) {
            return back()->with('error', 'Command is not allowed.');
        }

        $exitCode = 1;
        $output = '';

        try {
            if ($command === 'migrate_selected') {
                if (empty($validated['migration'])) {
                    return back()->with('error', 'Please select a migration.');
                }

                $migrationFile = basename($validated['migration']);
                $fullPath = database_path('migrations/' . $migrationFile . '.php');

                if (!file_exists($fullPath)) {
                    return back()->with('error', 'Selected migration file does not exist.');
                }

                $exitCode = Artisan::call('migrate', [
                    '--path' => 'database/migrations/' . $migrationFile . '.php',
                    '--force' => true,
                ]);
            } elseif ($command === 'migrate_rollback_step') {
                $exitCode = Artisan::call('migrate:rollback', [
                    '--step' => (int) ($validated['rollback_step'] ?? 1),
                    '--force' => true,
                ]);
            } elseif ($command === 'migrate_fresh') {
                $exitCode = Artisan::call('migrate:fresh', ['--force' => true]);
            } else {
                $artisanCommand = str_replace('_', ':', $command);
                $exitCode = Artisan::call($artisanCommand);
            }

            $output = trim(Artisan::output());
        } catch (\Throwable $e) {
            return back()->with('error', 'Command failed: ' . $e->getMessage());
        }

        return back()->with(
            $exitCode === 0 ? 'success' : 'error',
            $exitCode === 0
                ? 'Command executed successfully.'
                : 'Command finished with exit code: ' . $exitCode
        )->with('command_output', $output ?: 'No output');
    }

    private function availableCommands(): array
    {
        return [
            ['value' => 'migrate', 'label' => 'Run All Pending Migrations (migrate)'],
            ['value' => 'migrate_selected', 'label' => 'Run Selected Migration'],
            ['value' => 'migrate_rollback_step', 'label' => 'Rollback by Steps (migrate:rollback --step)'],
            ['value' => 'migrate_status', 'label' => 'Show Migration Status (migrate:status)'],
            ['value' => 'migrate_fresh', 'label' => 'Fresh Migrate - Drops all tables (migrate:fresh)'],
            ['value' => 'optimize_clear', 'label' => 'Optimize Clear (optimize:clear)'],
            ['value' => 'cache_clear', 'label' => 'Cache Clear (cache:clear)'],
            ['value' => 'config_clear', 'label' => 'Config Clear (config:clear)'],
            ['value' => 'route_clear', 'label' => 'Route Clear (route:clear)'],
            ['value' => 'view_clear', 'label' => 'View Clear (view:clear)'],
        ];
    }
}

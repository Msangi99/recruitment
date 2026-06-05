<?php

namespace App\Services;

use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class DeviceAssignmentService
{
    public function assign(Device $device, User $assignee, User $assigner): Device
    {
        $this->assertCanAssign($device, $assignee, $assigner);

        $device->update([
            'assigned_to_user_id' => $assignee->id,
            'assigned_by_user_id' => $assigner->id,
            'assigned_at' => now(),
            'status' => 'assigned',
        ]);

        return $device->fresh(['assignedTo', 'assignedBy']);
    }

    public function unassign(Device $device, User $actor): Device
    {
        if (! $actor->isAdmin()) {
            throw ValidationException::withMessages([
                'device_id' => 'Only administrators can unassign devices.',
            ]);
        }

        $device->update([
            'assigned_to_user_id' => null,
            'assigned_by_user_id' => null,
            'assigned_at' => null,
            'status' => 'available',
        ]);

        return $device->fresh();
    }

    public function assignableDevicesFor(User $assigner): Collection
    {
        if ($assigner->isAdmin()) {
            return Device::query()
                ->where(function ($query) {
                    $query->where('status', 'available')
                        ->orWhereNull('assigned_to_user_id');
                })
                ->orderBy('name')
                ->get();
        }

        return Device::query()
            ->where('assigned_to_user_id', $assigner->id)
            ->where('status', 'assigned')
            ->orderBy('name')
            ->get();
    }

    protected function assertCanAssign(Device $device, User $assignee, User $assigner): void
    {
        if ($assigner->isAdmin()) {
            if ($assignee->role !== 'regional_manager') {
                throw ValidationException::withMessages([
                    'assignee_id' => 'Administrators can only assign devices to regional managers.',
                ]);
            }

            if ($device->status === 'inactive') {
                throw ValidationException::withMessages([
                    'device_id' => 'Inactive devices cannot be assigned.',
                ]);
            }

            if ($device->assigned_to_user_id && $device->assigned_to_user_id !== $assignee->id) {
                throw ValidationException::withMessages([
                    'device_id' => 'This device is already assigned. Unassign it first.',
                ]);
            }

            return;
        }

        if ($assigner->isRegionalManager()) {
            if ($assignee->role !== 'team_leader' || $assignee->supervisor_id !== $assigner->id) {
                throw ValidationException::withMessages([
                    'assignee_id' => 'You can only assign devices to your team leaders.',
                ]);
            }

            if ($device->assigned_to_user_id !== $assigner->id) {
                throw ValidationException::withMessages([
                    'device_id' => 'You can only assign devices that are assigned to you.',
                ]);
            }

            return;
        }

        if ($assigner->isTeamLeader()) {
            if ($assignee->role !== 'agent' || $assignee->supervisor_id !== $assigner->id) {
                throw ValidationException::withMessages([
                    'assignee_id' => 'You can only assign devices to your agents.',
                ]);
            }

            if ($device->assigned_to_user_id !== $assigner->id) {
                throw ValidationException::withMessages([
                    'device_id' => 'You can only assign devices that are assigned to you.',
                ]);
            }

            return;
        }

        throw ValidationException::withMessages([
            'device_id' => 'You are not allowed to assign devices.',
        ]);
    }
}

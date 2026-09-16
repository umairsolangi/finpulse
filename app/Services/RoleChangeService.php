<?php

namespace App\Services;

use App\Enums\RoleChangeAction;
use App\Models\RoleChangeLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class RoleChangeService
{
    /**
     * Allowed assignable roles (Guest is the unauthenticated state, not assignable).
     */
    public const VALID_ROLES = [
        'Free Member',
        'Paid Subscriber',
        'Instructor',
        'Moderator',
        'Admin',
    ];

    /**
     * Change a user's role and write audit logs per role delta.
     *
     * @throws ValidationException
     */
    public function changeRole(User $actor, User $target, string $newRole): void
    {
        // 1. Validate role name
        if (! in_array($newRole, self::VALID_ROLES, true)) {
            throw ValidationException::withMessages([
                'role' => "The role '{$newRole}' is invalid. Only valid platform roles may be assigned.",
            ]);
        }

        // Ensure role exists in database
        if (! Role::where('name', $newRole)->where('guard_name', 'web')->exists()) {
            throw ValidationException::withMessages([
                'role' => "The role '{$newRole}' has not been seeded in the database.",
            ]);
        }

        // 2. Determine current role
        $currentRole = $target->getRoleNames()->first();

        // 3. No-op if role unchanged
        if ($currentRole === $newRole) {
            return;
        }

        // 4. Last-Admin safeguard:
        // If removing Admin from target, target is actor (self-demotion), and Admin count <= 1
        if ($currentRole === 'Admin' && $newRole !== 'Admin') {
            if ($target->id === $actor->id) {
                $adminCount = User::role('Admin')->count();
                if ($adminCount <= 1) {
                    throw ValidationException::withMessages([
                        'role' => 'Cannot remove the last Admin. Promote another user to Admin first.',
                    ]);
                }
            }
        }

        // 5, 6, 7. DB transaction with Spatie syncRoles and delta logging
        DB::transaction(function () use ($actor, $target, $currentRole, $newRole) {
            $now = now();

            // Log removal of old role if any
            if ($currentRole) {
                RoleChangeLog::create([
                    'target_user_id' => $target->id,
                    'changed_by_user_id' => $actor->id,
                    'action' => RoleChangeAction::REMOVED,
                    'role' => $currentRole,
                    'created_at' => $now,
                ]);
            }

            // Log assignment of new role
            RoleChangeLog::create([
                'target_user_id' => $target->id,
                'changed_by_user_id' => $actor->id,
                'action' => RoleChangeAction::ASSIGNED,
                'role' => $newRole,
                'created_at' => $now,
            ]);

            // Apply Spatie role synchronization
            $target->syncRoles([$newRole]);
        });
    }
}

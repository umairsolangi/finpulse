<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

class AssignFreeMemberRole
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        if ($event->user && method_exists($event->user, 'assignRole')) {
            Role::firstOrCreate(['name' => 'Free Member', 'guard_name' => 'web']);
            $event->user->assignRole('Free Member');
        }
    }
}

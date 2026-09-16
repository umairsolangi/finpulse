<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render()
    {
        $roles = Role::with('permissions')
            ->where('guard_name', 'web')
            ->get();

        return view('livewire.admin.roles.index', [
            'roles' => $roles,
        ]);
    }
}

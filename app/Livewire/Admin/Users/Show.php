<?php

namespace App\Livewire\Admin\Users;

use App\Models\RoleChangeLog;
use App\Models\User;
use App\Services\RoleChangeService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public User $user;

    public string $selectedRole = '';

    public function mount(int $id): void
    {
        $this->user = User::with([
            'roles.permissions',
            'subscriptions' => fn ($q) => $q->latest('starts_at'),
            'payments' => fn ($q) => $q->latest(),
            'badges',
        ])->findOrFail($id);

        $this->selectedRole = $this->user->getRoleNames()->first() ?? 'Free Member';
    }

    public function updateRole(RoleChangeService $service)
    {
        try {
            $service->changeRole(auth()->user(), $this->user, $this->selectedRole);
            $this->user->load('roles.permissions');
            session()->flash('success', "Role for {$this->user->name} successfully updated to {$this->selectedRole}.");
        } catch (ValidationException $e) {
            $this->addError('selectedRole', $e->validator->errors()->first('role') ?: $e->getMessage());
            $this->selectedRole = $this->user->getRoleNames()->first() ?? 'Free Member';
        }
    }

    public function render()
    {
        $currentRole = $this->user->getRoleNames()->first() ?? 'Free Member';

        $roleChangeLogs = RoleChangeLog::where('target_user_id', $this->user->id)
            ->with('changedByUser')
            ->latest('created_at')
            ->get();

        return view('livewire.admin.users.show', [
            'user' => $this->user,
            'currentRole' => $currentRole,
            'availableRoles' => RoleChangeService::VALID_ROLES,
            'roleChangeLogs' => $roleChangeLogs,
        ]);
    }
}

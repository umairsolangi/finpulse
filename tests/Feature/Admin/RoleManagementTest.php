<?php

use App\Enums\RoleChangeAction;
use App\Livewire\Admin\RoleChanges\Index as RoleChangesIndex;
use App\Livewire\Admin\Roles\Index as RolesIndex;
use App\Livewire\Admin\Users\Show as UsersShow;
use App\Models\RoleChangeLog;
use App\Models\User;
use App\Services\RoleChangeService;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('guests are redirected to login when accessing admin routes', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $this->get(route('admin.users.index'))->assertRedirect(route('login'));
    $this->get(route('admin.users.show', $admin->id))->assertRedirect(route('login'));
    $this->get(route('admin.roles.index'))->assertRedirect(route('login'));
    $this->get(route('admin.role-changes.index'))->assertRedirect(route('login'));
    $this->get(route('admin.settings.index'))->assertRedirect(route('login'));
});

test('non-admin roles receive 403 forbidden when accessing admin routes', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    $this->actingAs($user);

    $this->get(route('admin.users.index'))->assertForbidden();
    $this->get(route('admin.users.show', $user->id))->assertForbidden();
    $this->get(route('admin.roles.index'))->assertForbidden();
    $this->get(route('admin.role-changes.index'))->assertForbidden();
    $this->get(route('admin.settings.index'))->assertForbidden();
})->with(['Free Member', 'Paid Subscriber', 'Instructor', 'Moderator']);

test('admin can access all admin routes', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $this->actingAs($admin);

    $this->get(route('admin.users.index'))->assertOk();
    $this->get(route('admin.users.show', $admin->id))->assertOk();
    $this->get(route('admin.roles.index'))->assertOk();
    $this->get(route('admin.role-changes.index'))->assertOk();
    $this->get(route('admin.settings.index'))->assertOk();
});

test('admin can change user role and both removal and assignment are logged', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $target = User::factory()->create();
    $target->assignRole('Free Member');

    $this->actingAs($admin);

    Livewire::test(UsersShow::class, ['id' => $target->id])
        ->set('selectedRole', 'Instructor')
        ->call('updateRole')
        ->assertHasNoErrors();

    expect($target->fresh()->hasRole('Instructor'))->toBeTrue()
        ->and($target->fresh()->hasRole('Free Member'))->toBeFalse();

    // Verify dual delta logs
    $logs = RoleChangeLog::where('target_user_id', $target->id)->orderBy('id')->get();
    expect($logs)->toHaveCount(2);

    $removal = $logs->first();
    expect($removal->action)->toBe(RoleChangeAction::REMOVED)
        ->and($removal->role)->toBe('Free Member')
        ->and($removal->changed_by_user_id)->toBe($admin->id);

    $assignment = $logs->last();
    expect($assignment->action)->toBe(RoleChangeAction::ASSIGNED)
        ->and($assignment->role)->toBe('Instructor')
        ->and($assignment->changed_by_user_id)->toBe($admin->id);
});

test('last admin self-demotion is strictly prevented', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    expect(User::role('Admin')->count())->toBe(1);

    $this->actingAs($admin);

    Livewire::test(UsersShow::class, ['id' => $admin->id])
        ->set('selectedRole', 'Free Member')
        ->call('updateRole')
        ->assertHasErrors(['selectedRole']);

    expect($admin->fresh()->hasRole('Admin'))->toBeTrue();
    expect(RoleChangeLog::count())->toBe(0);
});

test('admin can change role when another admin exists', function () {
    $admin1 = User::factory()->create();
    $admin1->assignRole('Admin');

    $admin2 = User::factory()->create();
    $admin2->assignRole('Admin');

    expect(User::role('Admin')->count())->toBe(2);

    $this->actingAs($admin1);

    Livewire::test(UsersShow::class, ['id' => $admin2->id])
        ->set('selectedRole', 'Instructor')
        ->call('updateRole')
        ->assertHasNoErrors();

    expect($admin2->fresh()->hasRole('Instructor'))->toBeTrue()
        ->and($admin2->fresh()->hasRole('Admin'))->toBeFalse()
        ->and(User::role('Admin')->count())->toBe(1);
});

test('assigning guest role or invalid role is rejected', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $target = User::factory()->create();
    $target->assignRole('Free Member');

    $service = app(RoleChangeService::class);

    expect(fn () => $service->changeRole($admin, $target, 'Guest'))
        ->toThrow(ValidationException::class);

    expect(fn () => $service->changeRole($admin, $target, 'NonExistentRole'))
        ->toThrow(ValidationException::class);
});

test('roles index displays seeded roles and their permissions without guest', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $this->actingAs($admin);

    Livewire::test(RolesIndex::class)
        ->assertSee('Admin')
        ->assertSee('Instructor')
        ->assertSee('Moderator')
        ->assertSee('Paid Subscriber')
        ->assertSee('Free Member')
        ->assertDontSee('Guest')
        ->assertSee('users.manage')
        ->assertSee('settings.manage');
});

test('role changes index displays audit trail and supports filtering', function () {
    $admin = User::factory()->create(['name' => 'Super Admin', 'email' => 'admin@finpulse.test']);
    $admin->assignRole('Admin');

    $target1 = User::factory()->create(['name' => 'Alice Member', 'email' => 'alice@finpulse.test']);
    $target1->assignRole('Free Member');

    $target2 = User::factory()->create(['name' => 'Bob Member', 'email' => 'bob@finpulse.test']);
    $target2->assignRole('Free Member');

    $service = app(RoleChangeService::class);
    $service->changeRole($admin, $target1, 'Instructor');
    $service->changeRole($admin, $target2, 'Moderator');

    $this->actingAs($admin);

    Livewire::test(RoleChangesIndex::class)
        ->assertSee('Alice Member')
        ->assertSee('Bob Member')
        ->assertSee('Instructor')
        ->assertSee('Moderator')
        ->set('targetFilter', 'Alice')
        ->assertSee('Alice Member')
        ->assertDontSee('Bob Member');
});

<?php

use App\Enums\PostCategory;
use App\Livewire\Feed;
use App\Livewire\LiveSessions\LiveSessionCreate;
use App\Livewire\Research\ResearchCreate;
use App\Models\Comment;
use App\Models\ContentItem;
use App\Models\LiveSession;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('feed post and comment creation permissions', function () {
    $freeMember = User::factory()->create();
    $freeMember->assignRole('Free Member');

    $this->actingAs($freeMember);

    Livewire::test(Feed::class)
        ->set('category', PostCategory::STOCKS->value)
        ->set('body', 'Test community post from free member.')
        ->call('createPost')
        ->assertHasNoErrors();

    expect(Post::count())->toBe(1);

    $post = Post::first();

    Livewire::test(Feed::class)
        ->set("commentBody.{$post->id}", 'Great discussion point!')
        ->call('addComment', $post->id)
        ->assertHasNoErrors();

    expect(Comment::count())->toBe(1);
});

test('feed moderation allows moderators and admins to delete posts and comments while denying regular members', function () {
    $author = User::factory()->create();
    $author->assignRole('Free Member');

    $post = Post::create([
        'user_id' => $author->id,
        'category' => PostCategory::STOCKS->value,
        'body' => 'Post to be moderated',
    ]);

    $comment = Comment::create([
        'post_id' => $post->id,
        'user_id' => $author->id,
        'body' => 'Comment to be moderated',
    ]);

    // Free member cannot delete
    $regularUser = User::factory()->create();
    $regularUser->assignRole('Free Member');
    $this->actingAs($regularUser);

    Livewire::test(Feed::class)
        ->call('deletePost', $post->id)
        ->assertForbidden();

    Livewire::test(Feed::class)
        ->call('deleteComment', $comment->id)
        ->assertForbidden();

    expect(Post::count())->toBe(1)
        ->and(Comment::count())->toBe(1);

    // Moderator can delete
    $moderator = User::factory()->create();
    $moderator->assignRole('Moderator');
    $this->actingAs($moderator);

    Livewire::test(Feed::class)
        ->call('deleteComment', $comment->id);

    expect(Comment::count())->toBe(0);

    Livewire::test(Feed::class)
        ->call('deletePost', $post->id);

    expect(Post::count())->toBe(0);
});

test('research creation enforces server-side authorization against non-creators', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    $this->actingAs($user);

    $this->get(route('research.create'))->assertForbidden();

    Livewire::test(ResearchCreate::class)
        ->assertForbidden();
})->with(['Free Member', 'Paid Subscriber', 'Moderator']);

test('instructors and admins can create research summaries', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    $this->actingAs($user);

    $this->get(route('research.create'))->assertOk();

    Livewire::test(ResearchCreate::class)
        ->set('title', 'KSE-100 Performance Q3')
        ->set('body', 'Deep dive analysis of index performance and macro factors.')
        ->set('tier', 'free')
        ->set('durationMinutes', 10)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect();

    expect(ContentItem::where('title', 'KSE-100 Performance Q3')->exists())->toBeTrue();
})->with(['Instructor', 'Admin']);

test('live session creation enforces server-side authorization against non-instructors', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    $this->actingAs($user);

    $this->get(route('live-sessions.create'))->assertForbidden();

    Livewire::test(LiveSessionCreate::class)
        ->assertForbidden();
})->with(['Free Member', 'Paid Subscriber', 'Moderator']);

test('instructors and admins can schedule live sessions', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    $this->actingAs($user);

    $this->get(route('live-sessions.create'))->assertOk();

    Livewire::test(LiveSessionCreate::class)
        ->set('title', 'Weekly Market Wrap')
        ->set('description', 'Live overview of major earnings and sector trends.')
        ->set('type', 'webinar')
        ->set('scheduled_at', now()->addDays(2)->setTime(17, 0)->format('Y-m-d\TH:i'))
        ->set('duration_minutes', 45)
        ->set('tier', 'paid')
        ->set('meeting_url', 'https://meet.google.com/test-session')
        ->set('max_attendees', 50)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('live-sessions.index'));

    expect(LiveSession::where('title', 'Weekly Market Wrap')->exists())->toBeTrue();
})->with(['Instructor', 'Admin']);

test('settings page is only accessible by users with settings.manage permission', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $this->actingAs($admin);
    $this->get(route('admin.settings.index'))->assertOk();

    $instructor = User::factory()->create();
    $instructor->assignRole('Instructor');

    $this->actingAs($instructor);
    $this->get(route('admin.settings.index'))->assertForbidden();
});

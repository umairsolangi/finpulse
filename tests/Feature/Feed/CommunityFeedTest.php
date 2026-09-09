<?php

use App\Enums\PostCategory;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('guest is redirected away from /feed to login page', function () {
    $response = $this->get('/feed');

    $response->assertRedirect('/login');
});

test('logged in Free Member can view feed and create a post', function () {
    $user = User::factory()->create();
    $user->assignRole('Free Member');

    $this->actingAs($user);

    $response = $this->get('/feed');
    $response->assertOk();

    Livewire::test('feed')
        ->set('category', PostCategory::STOCKS->value)
        ->set('body', 'This is my first financial post about stocks.')
        ->call('createPost')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
        'category' => PostCategory::STOCKS->value,
        'body' => 'This is my first financial post about stocks.',
    ]);
});

test('Free Member without post.moderate permission cannot delete someone else post', function () {
    $author = User::factory()->create();
    $author->assignRole('Free Member');

    $post = Post::factory()->create([
        'user_id' => $author->id,
        'category' => PostCategory::NEWS,
        'body' => 'Original news post body',
    ]);

    $otherUser = User::factory()->create();
    $otherUser->assignRole('Free Member');

    $this->actingAs($otherUser);

    Livewire::test('feed')
        ->call('deletePost', $post->id)
        ->assertStatus(403);

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
    ]);
});

test('Moderator with post.moderate permission can delete a post and its comments are removed', function () {
    $author = User::factory()->create();
    $author->assignRole('Free Member');

    $post = Post::factory()->create([
        'user_id' => $author->id,
        'category' => PostCategory::BASICS,
        'body' => 'Basics post body to be deleted',
    ]);

    $comment = Comment::factory()->create([
        'post_id' => $post->id,
        'user_id' => $author->id,
        'body' => 'Comment on basics post',
    ]);

    $moderator = User::factory()->create();
    $moderator->assignRole('Moderator');

    $this->actingAs($moderator);

    Livewire::test('feed')
        ->call('deletePost', $post->id)
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
});

test('category filtering returns only posts in selected category', function () {
    $user = User::factory()->create();
    $user->assignRole('Free Member');

    $stocksPost = Post::factory()->create([
        'category' => PostCategory::STOCKS,
        'body' => 'Stocks post content',
    ]);

    $newsPost = Post::factory()->create([
        'category' => PostCategory::NEWS,
        'body' => 'News post content',
    ]);

    $this->actingAs($user);

    Livewire::test('feed')
        ->call('selectCategory', PostCategory::STOCKS->value)
        ->assertSee('Stocks post content')
        ->assertDontSee('News post content');
});

test('authorized user can add a comment to a post', function () {
    $user = User::factory()->create();
    $user->assignRole('Free Member');

    $post = Post::factory()->create([
        'category' => PostCategory::MUTUAL_FUNDS,
        'body' => 'Mutual funds discussion',
    ]);

    $this->actingAs($user);

    Livewire::test('feed')
        ->set("commentBody.{$post->id}", 'Great insights on mutual funds!')
        ->call('addComment', $post->id)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('comments', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'body' => 'Great insights on mutual funds!',
    ]);
});

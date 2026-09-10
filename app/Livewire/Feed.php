<?php

namespace App\Livewire;

use App\Enums\PostCategory;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use App\Services\ActivityScoreService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Feed extends Component
{
    use WithPagination;

    #[Url(as: 'category')]
    public string $selectedCategory = 'all';

    // Create post fields
    public string $category = '';

    public string $body = '';

    // Comment input array keyed by post id
    public array $commentBody = [];

    // Array of open comment thread post ids
    public array $openComments = [];

    public function selectCategory(string $category): void
    {
        $this->selectedCategory = $category;
        $this->resetPage();
    }

    public function createPost(): void
    {
        abort_unless(auth()->user()?->can('post.create'), 403, 'Unauthorized action.');

        $validated = $this->validate([
            'category' => ['required', Rule::enum(PostCategory::class)],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        Post::create([
            'user_id' => auth()->id(),
            'category' => $validated['category'],
            'body' => $validated['body'],
        ]);

        $this->reset(['category', 'body']);
        $this->resetPage();
        $this->checkAndDispatchEarnedBadge();
    }

    public function toggleReaction(int $postId): void
    {
        if (auth()->guest()) {
            $this->redirect(route('login'));

            return;
        }

        $userId = auth()->id();
        $reaction = Reaction::where('post_id', $postId)->where('user_id', $userId)->first();

        if ($reaction) {
            $reaction->delete();
        } else {
            Reaction::firstOrCreate([
                'post_id' => $postId,
                'user_id' => $userId,
            ]);
            $this->checkAndDispatchEarnedBadge();
        }
    }

    public function toggleComments(int $postId): void
    {
        if (in_array($postId, $this->openComments)) {
            $this->openComments = array_values(array_diff($this->openComments, [$postId]));
        } else {
            $this->openComments[] = $postId;
        }
    }

    public function addComment(int $postId): void
    {
        abort_unless(auth()->user()?->can('post.comment'), 403, 'Unauthorized action.');

        $this->validate([
            "commentBody.{$postId}" => ['required', 'string', 'max:1000'],
        ], [
            "commentBody.{$postId}.required" => 'Comment cannot be empty.',
            "commentBody.{$postId}.max" => 'Comment cannot exceed 1000 characters.',
        ]);

        $post = Post::findOrFail($postId);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'body' => $this->commentBody[$postId],
        ]);

        $this->commentBody[$postId] = '';

        if (! in_array($postId, $this->openComments)) {
            $this->openComments[] = $postId;
        }

        $this->checkAndDispatchEarnedBadge();
    }

    protected function checkAndDispatchEarnedBadge(): void
    {
        if ($badge = app(ActivityScoreService::class)->pullLastAwardedBadge()) {
            $this->dispatch('badge-earned', badge: $badge->name);
        }
    }

    public function deletePost(int $postId): void
    {
        abort_unless(auth()->user()?->can('post.moderate'), 403, 'Unauthorized action.');

        $post = Post::findOrFail($postId);
        $post->delete();
    }

    public function deleteComment(int $commentId): void
    {
        abort_unless(auth()->user()?->can('post.moderate'), 403, 'Unauthorized action.');

        $comment = Comment::findOrFail($commentId);
        $comment->delete();
    }

    public function render()
    {
        $userId = auth()->id();

        $query = Post::with([
            'user.badges',
            'comments' => fn ($q) => $q->orderBy('created_at', 'asc')->with('user.badges'),
            'reactions' => fn ($q) => $q->where('user_id', $userId),
        ])->withCount(['comments', 'reactions'])->latest();

        if ($this->selectedCategory !== 'all' && PostCategory::tryFrom($this->selectedCategory)) {
            $query->where('category', $this->selectedCategory);
        }

        $posts = $query->paginate(10);

        return view('livewire.feed', [
            'posts' => $posts,
            'categories' => PostCategory::cases(),
        ]);
    }
}

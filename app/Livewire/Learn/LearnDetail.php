<?php

namespace App\Livewire\Learn;

use App\Models\ContentBookmark;
use App\Models\ContentComment;
use App\Models\ContentItem;
use App\Models\ContentView;
use App\Services\ActivityScoreService;
use App\Services\BadgeAwardService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class LearnDetail extends Component
{
    public ContentItem $contentItem;

    public string $languageMode = 'en';

    public bool $isBookmarked = false;

    public bool $isCompleted = false;

    public ?int $selectedOption = null;

    public bool $quizSubmitted = false;

    public bool $quizCorrect = false;

    public ?string $quizFeedback = null;

    public string $newComment = '';

    public function mount(string $slug): void
    {
        $this->contentItem = ContentItem::with(['comments.user', 'author'])
            ->where('slug', $slug)
            ->whereNotNull('published_at')
            ->firstOrFail();

        if (auth()->check()) {
            $user = auth()->user();
            $view = ContentView::firstOrCreate([
                'user_id' => $user->id,
                'content_item_id' => $this->contentItem->id,
            ]);

            $this->isCompleted = ! is_null($view->completed_at);
            $this->isBookmarked = ContentBookmark::where('user_id', $user->id)
                ->where('content_item_id', $this->contentItem->id)
                ->exists();

            $awardedBadge = app(BadgeAwardService::class)->checkMarketExplorer($user);
            if ($awardedBadge) {
                $this->dispatch('badge-earned', badge: $awardedBadge->name);
            }
        }
    }

    public function toggleLanguage(): void
    {
        $this->languageMode = $this->languageMode === 'en' ? 'ur' : 'en';
    }

    public function toggleBookmark(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        $userId = auth()->id();
        $bookmark = ContentBookmark::where('user_id', $userId)
            ->where('content_item_id', $this->contentItem->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $this->isBookmarked = false;
            session()->flash('bookmark_message', 'Removed from saved articles.');
        } else {
            ContentBookmark::create([
                'user_id' => $userId,
                'content_item_id' => $this->contentItem->id,
            ]);
            $this->isBookmarked = true;
            session()->flash('bookmark_message', 'Saved to your reading list!');
        }
    }

    public function markAsCompleted(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        $user = auth()->user();
        $view = ContentView::firstOrCreate([
            'user_id' => $user->id,
            'content_item_id' => $this->contentItem->id,
        ]);

        if (! $view->completed_at) {
            $view->update(['completed_at' => now()]);
            $this->isCompleted = true;

            $badge = app(ActivityScoreService::class)->recordActivity($user, 'content_completed');
            if ($badge) {
                $this->dispatch('badge-earned', badge: $badge->name);
            }

            session()->flash('completed_message', '🎉 Lesson marked as completed! Points added to your streak.');
        } else {
            $view->update(['completed_at' => null]);
            $this->isCompleted = false;
            session()->flash('completed_message', 'Marked as uncompleted.');
        }
    }

    public function submitQuiz(): void
    {
        if (is_null($this->selectedOption)) {
            return;
        }

        $quiz = $this->contentItem->quiz_data;
        if (! $quiz || ! isset($quiz['correct_index'])) {
            return;
        }

        $this->quizSubmitted = true;
        $this->quizCorrect = ((int) $this->selectedOption === (int) $quiz['correct_index']);
        $this->quizFeedback = $this->quizCorrect
            ? ($quiz['explanation'] ?? 'Correct! Great understanding of the concept.')
            : ($quiz['explanation'] ?? 'Not quite. Check the explanation and re-read the section.');

        if ($this->quizCorrect && auth()->check() && ! $this->isCompleted) {
            $this->markAsCompleted();
        }
    }

    public function postComment(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        $this->validate([
            'newComment' => 'required|string|min:3|max:1000',
        ]);

        ContentComment::create([
            'user_id' => auth()->id(),
            'content_item_id' => $this->contentItem->id,
            'comment' => trim($this->newComment),
        ]);

        $this->newComment = '';
        $this->contentItem->load('comments.user');
        session()->flash('comment_message', 'Your question/thought has been shared with the community!');
    }

    public function render()
    {
        $relatedItems = ContentItem::query()
            ->where('id', '!=', $this->contentItem->id)
            ->whereNotNull('published_at')
            ->where(function ($q) {
                $q->where('skill_level', $this->contentItem->skill_level)
                    ->orWhere('type', $this->contentItem->type);
            })
            ->take(3)
            ->get();

        return view('livewire.learn.learn-detail', [
            'item' => $this->contentItem,
            'relatedItems' => $relatedItems,
        ]);
    }
}

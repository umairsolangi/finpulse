<?php

namespace App\Livewire\Research;

use App\Enums\ContentTier;
use App\Enums\ContentType;
use App\Enums\Language;
use App\Enums\SkillLevel;
use App\Models\ContentItem;
use App\Models\User;
use App\Notifications\NewResearchSummaryPublished;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ResearchCreate extends Component
{
    public string $title = '';

    public string $body = '';

    public string $tier = 'free';

    public ?string $publishedAt = null;

    public int $durationMinutes = 5;

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tier' => 'required|in:free,registered,paid',
            'publishedAt' => 'nullable|date',
            'durationMinutes' => 'required|integer|min:1|max:120',
        ];
    }

    public function mount(): void
    {
        abort_unless(
            auth()->check() && (
                auth()->user()->can('content.publish') ||
                auth()->user()->hasRole(['Instructor', 'Admin'])
            ),
            403,
            'Unauthorized to publish research.'
        );

        $this->publishedAt = now()->format('Y-m-d\TH:i');
    }

    public function save(): mixed
    {
        abort_unless(
            auth()->check() && (
                auth()->user()->can('content.publish') ||
                auth()->user()->hasRole(['Instructor', 'Admin'])
            ),
            403,
            'Unauthorized to publish research.'
        );

        $this->validate();

        $publishedAtDate = $this->publishedAt ? Carbon::parse($this->publishedAt) : now();

        $item = ContentItem::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title).'-'.Str::lower(Str::random(5)),
            'type' => ContentType::RESEARCH_SUMMARY,
            'tier' => ContentTier::from($this->tier),
            'language' => Language::ENGLISH,
            'skill_level' => SkillLevel::INTERMEDIATE,
            'body' => $this->body,
            'duration_minutes' => $this->durationMinutes,
            'published_at' => $publishedAtDate,
            'created_by' => auth()->id(),
        ]);

        // If published immediately (published_at <= now()), notify active users
        if ($item->published_at && $item->published_at->lte(now())) {
            $activeUsers = User::whereNotNull('last_login_at')
                ->where('last_login_at', '>=', now()->subDays(30))
                ->where('id', '!=', auth()->id())
                ->get();

            if ($activeUsers->isNotEmpty()) {
                Notification::send($activeUsers, new NewResearchSummaryPublished($item));
            }
        }

        session()->flash('status', 'Research summary published successfully.');

        return redirect()->route('research.show', $item->slug);
    }

    public function render()
    {
        return view('livewire.research.research-create', [
            'tiers' => ContentTier::cases(),
        ]);
    }
}

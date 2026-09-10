<?php

namespace App\Livewire;

use App\Enums\PostCategory;
use App\Models\UserInterest;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Onboarding extends Component
{
    /**
     * Selected category values.
     *
     * @var array<string>
     */
    public array $selectedInterests = [];

    public function mount(): void
    {
        $user = auth()->user();

        // A user should only see this onboarding step once
        if ($user && $user->onboarded_at !== null) {
            $this->redirect(route('learn.index'), navigate: true);
        }
    }

    public function toggleInterest(string $category): void
    {
        if (in_array($category, $this->selectedInterests)) {
            $this->selectedInterests = array_values(array_diff($this->selectedInterests, [$category]));
        } else {
            if (count($this->selectedInterests) < 3) {
                $this->selectedInterests[] = $category;
            }
        }
    }

    public function submit(): void
    {
        $this->validate([
            'selectedInterests' => ['required', 'array', 'min:2', 'max:3'],
            'selectedInterests.*' => ['required', Rule::enum(PostCategory::class)],
        ], [
            'selectedInterests.required' => 'Please select at least 2 interests to personalize your experience.',
            'selectedInterests.min' => 'Please select at least 2 interests to continue.',
            'selectedInterests.max' => 'You can select at most 3 interests.',
        ]);

        $user = auth()->user();

        // Save selections to user_interests
        foreach ($this->selectedInterests as $categoryValue) {
            UserInterest::firstOrCreate([
                'user_id' => $user->id,
                'post_category' => $categoryValue,
            ]);
        }

        // Set onboarded_at timestamp on user
        $user->update([
            'onboarded_at' => now(),
        ]);

        // Redirect to /learn pre-filtered by selected interests
        $interestsParam = implode(',', $this->selectedInterests);

        $this->redirect(route('learn.index', ['interests' => $interestsParam]), navigate: true);
    }

    public function render()
    {
        $categories = [
            [
                'value' => PostCategory::STOCKS->value,
                'label' => 'Stocks & Equities',
                'description' => 'Market trends, fundamental analysis, valuations & equity strategies.',
                'icon' => '📈',
                'color' => 'blue',
            ],
            [
                'value' => PostCategory::MUTUAL_FUNDS->value,
                'label' => 'Mutual Funds & ETFs',
                'description' => 'Index funds, SIP planning, diversification, and passive portfolios.',
                'icon' => '🏛️',
                'color' => 'amber',
            ],
            [
                'value' => PostCategory::BASICS->value,
                'label' => 'Financial Basics',
                'description' => 'Budgeting, compound interest, emergency reserves & debt control.',
                'icon' => '🌱',
                'color' => 'emerald',
            ],
            [
                'value' => PostCategory::NEWS->value,
                'label' => 'Market News & Pulse',
                'description' => 'Daily macro updates, central bank decisions & corporate earnings.',
                'icon' => '📰',
                'color' => 'indigo',
            ],
        ];

        return view('livewire.onboarding', [
            'categories' => $categories,
        ]);
    }
}

<?php

use App\Livewire\Assistant;
use App\Models\KnowledgeChunk;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;

beforeEach(function () {
    RateLimiter::clear('assistant:1');
});

// --- Auth ---

it('redirects guests away from /assistant', function () {
    $this->get(route('assistant'))->assertRedirect(route('login'));
});

it('allows logged-in users to visit /assistant', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('assistant'))->assertOk();
});

// --- Empty state ---

it('renders the empty state when there are no messages', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Assistant::class)
        ->assertSee('Ask anything about FinPulse')
        ->assertSee('Educational information only');
});

// --- No-match fallback ---

it('returns the fixed fallback reply when no knowledge chunks match', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Assistant::class)
        ->set('question', 'What is the meaning of life?')
        ->call('sendMessage')
        ->assertSee("I don't have information on that yet");
});

// --- Groq API call with matched chunks ---

it('calls Groq and displays the answer when chunks match', function () {
    $user = User::factory()->create();

    KnowledgeChunk::create([
        'source' => 'finpulse-guide.pdf',
        'page' => 3,
        'title' => 'FinPulse Courses',
        'content' => 'FinPulse offers beginner and advanced stock market courses covering technical and fundamental analysis.',
    ]);

    Http::fake([
        'https://api.groq.com/*' => Http::response([
            'choices' => [['message' => ['content' => 'FinPulse offers stock market courses.']]],
        ], 200),
    ]);

    Livewire::actingAs($user)
        ->test(Assistant::class)
        ->set('question', 'What courses does FinPulse offer?')
        ->call('sendMessage')
        ->assertSee('FinPulse offers stock market courses.')
        ->assertSee('finpulse-guide.pdf');
});

// --- 429 rate-limit from Groq ---

it('shows a friendly busy message on Groq 429', function () {
    $user = User::factory()->create();

    KnowledgeChunk::create([
        'source' => 'pricing.md',
        'page' => null,
        'title' => 'Pricing Plans',
        'content' => 'FinPulse subscription includes community access and live sessions.',
    ]);

    Http::fake([
        'https://api.groq.com/*' => Http::response([], 429, ['retry-after' => '5']),
    ]);

    Livewire::actingAs($user)
        ->test(Assistant::class)
        ->set('question', 'subscription community sessions')
        ->call('sendMessage')
        ->assertSee('The assistant is busy');
});

// --- Laravel rate limiter ---

it('blocks the user after 5 questions per minute', function () {
    $user = User::factory()->create();
    $key = 'assistant:'.$user->id;

    for ($i = 0; $i < 5; $i++) {
        RateLimiter::hit($key, 60);
    }

    Livewire::actingAs($user)
        ->test(Assistant::class)
        ->set('question', 'Any question')
        ->call('sendMessage')
        ->assertSee("You've reached the question limit");
});

// --- Clear chat ---

it('clears the chat history', function () {
    $user = User::factory()->create();

    $component = Livewire::actingAs($user)->test(Assistant::class);

    $component->set('messages', [
        ['role' => 'user', 'content' => 'Hello', 'sources' => []],
    ]);

    $component->call('clearChat')->assertSet('messages', []);
});

// --- Source attribution ---

it('displays page number in source attribution', function () {
    $user = User::factory()->create();

    KnowledgeChunk::create([
        'source' => 'investment-basics.pdf',
        'page' => 7,
        'title' => 'What is a Stock',
        'content' => 'A stock is a share of ownership in a company traded on a stock exchange.',
    ]);

    Http::fake([
        'https://api.groq.com/*' => Http::response([
            'choices' => [['message' => ['content' => 'A stock is a share of ownership.']]],
        ], 200),
    ]);

    Livewire::actingAs($user)
        ->test(Assistant::class)
        ->set('question', 'What is a stock?')
        ->call('sendMessage')
        ->assertSee('investment-basics.pdf')
        ->assertSee('p.7');
});

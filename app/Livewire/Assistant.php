<?php

namespace App\Livewire;

use App\Models\KnowledgeChunk;
use App\Services\GroqService;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;
use RuntimeException;

#[Layout('layouts.app')]
class Assistant extends Component
{
    /** @var string The current question typed by the user. */
    public string $question = '';

    /**
     * Chat history kept in Livewire state only — never stored in the database.
     *
     * Each entry:
     *   ['role' => 'user'|'assistant', 'content' => string, 'sources' => array]
     *
     * sources entries: ['name' => string, 'page' => int|null]
     *
     * @var array<int, array{role: string, content: string, sources: array}>
     */
    public array $messages = [];

    /** @var bool True while waiting for Groq to respond. */
    public bool $isThinking = false;

    /**
     * Fixed fallback reply when no knowledge chunks match the question.
     * Saves quota and enforces the "only from the material" rule.
     */
    private const NO_MATCH_REPLY = "I don't have information on that yet. Try asking about FinPulse's courses, community, or pricing.";

    /**
     * System prompt injected with knowledge excerpts before calling Groq.
     * Placeholders: %s = the concatenated excerpt block.
     */
    private const SYSTEM_TEMPLATE = <<<'PROMPT'
You are the FinPulse educational assistant. Answer ONLY from the excerpts provided below.
Rules you must always follow:
- Answer only from the excerpts. If the excerpts don't contain the answer, say you don't know.
- Never give personal investment advice or tell anyone to buy or sell a specific security.
- Keep answers short and in simple English.

--- EXCERPTS ---
%s
--- END EXCERPTS ---
PROMPT;

    public function sendMessage(): void
    {
        $question = trim($this->question);

        if ($question === '') {
            return;
        }

        // --- Rate limiting: 5 questions per minute per user ---
        $rateLimitKey = 'assistant:'.auth()->id();
        if (RateLimiter::tooManyAttempts($rateLimitKey, maxAttempts: 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $this->appendAssistantMessage(
                "You've reached the question limit. Please wait {$seconds} second(s) before asking again.",
                []
            );
            $this->question = '';

            return;
        }
        RateLimiter::hit($rateLimitKey, decaySeconds: 60);

        // Append the user's question to the chat history
        $this->messages[] = ['role' => 'user', 'content' => $question, 'sources' => []];
        $this->question = '';
        $this->isThinking = true;

        // --- FULLTEXT search: top 4 chunks ---
        $chunks = KnowledgeChunk::search($question, limit: 4)->get();

        if ($chunks->isEmpty()) {
            $this->isThinking = false;
            $this->appendAssistantMessage(self::NO_MATCH_REPLY, []);

            return;
        }

        // Build the excerpt block injected into the system prompt
        $excerptBlock = $chunks->map(function (KnowledgeChunk $chunk, int $i): string {
            $label = "[{$i}] {$chunk->title}";
            if ($chunk->page !== null) {
                $label .= " (page {$chunk->page})";
            }

            return "{$label}\n{$chunk->content}";
        })->implode("\n\n---\n\n");

        $systemPrompt = sprintf(self::SYSTEM_TEMPLATE, $excerptBlock);

        // Build source list from DB data — never ask the model to produce citations
        $sources = $chunks->map(fn (KnowledgeChunk $c) => [
            'name' => $c->source,
            'page' => $c->page,
        ])->unique('name')->values()->all();

        // --- Call Groq ---
        try {
            $answer = app(GroqService::class)->chat($systemPrompt, $question);
        } catch (RuntimeException $e) {
            $this->isThinking = false;
            $errorCode = $e->getMessage();

            if (str_starts_with($errorCode, 'rate_limit:')) {
                $retryAfter = str_replace('rate_limit:', '', $errorCode);
                $this->appendAssistantMessage(
                    "The assistant is busy. Please try again in {$retryAfter} second(s).",
                    []
                );
            } elseif ($errorCode === 'timeout') {
                $this->appendAssistantMessage(
                    'The request timed out. Please try again in a moment.',
                    []
                );
            } else {
                $this->appendAssistantMessage(
                    'Something went wrong. Please try again in a moment.',
                    []
                );
            }

            return;
        }

        $this->isThinking = false;
        $this->appendAssistantMessage($answer, $sources);
    }

    private function appendAssistantMessage(string $content, array $sources): void
    {
        $this->messages[] = [
            'role' => 'assistant',
            'content' => $content,
            'sources' => $sources,
        ];
    }

    public function clearChat(): void
    {
        $this->messages = [];
        $this->question = '';
        $this->isThinking = false;
    }

    public function render()
    {
        return view('livewire.assistant');
    }
}

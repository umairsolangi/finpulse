<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Thin wrapper around the Groq chat-completions API.
 *
 * Groq uses an OpenAI-compatible REST interface:
 *   POST https://api.groq.com/openai/v1/chat/completions
 *
 * The API key is read from config('services.groq.api_key') — never hardcoded.
 * The model is read from config('services.groq.model') so it can be changed
 * by editing GROQ_MODEL in .env without touching code.
 */
class GroqService
{
    private string $apiKey;

    private string $model;

    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
        $this->model = config('services.groq.model', 'llama-3.1-8b-instant');
        $this->baseUrl = config('services.groq.base_url', 'https://api.groq.com/openai/v1');
    }

    /**
     * Send a chat completion request.
     *
     * @param  string  $systemPrompt  The system instruction with injected knowledge excerpts.
     * @param  string  $userQuestion  The user's question.
     * @param  int  $maxTokens  Maximum tokens in the response (keep small for free tier).
     * @return string The assistant's reply.
     *
     * @throws RuntimeException On HTTP 429 (rate-limit) or any other API failure.
     */
    public function chat(string $systemPrompt, string $userQuestion, int $maxTokens = 400): string
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(20)
                ->post("{$this->baseUrl}/chat/completions", [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userQuestion],
                    ],
                    'max_tokens' => $maxTokens,
                    'temperature' => 0.2, // low temperature keeps answers factual
                ]);

            if ($response->status() === 429) {
                $retryAfter = $response->header('retry-after') ?? 'a few';
                throw new RuntimeException("rate_limit:{$retryAfter}");
            }

            if (! $response->successful()) {
                throw new RuntimeException('api_error');
            }

            return $response->json('choices.0.message.content') ?? 'Sorry, I received an empty response.';

        } catch (ConnectionException) {
            throw new RuntimeException('timeout');
        } catch (RequestException) {
            throw new RuntimeException('api_error');
        }
    }
}

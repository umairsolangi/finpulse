<?php

namespace App\Livewire;

use Livewire\Attributes\On;

class AssistantWidget extends Assistant
{
    /** @var bool Whether the popup chat window is open. */
    public bool $isOpen = false;

    #[On('open-assistant')]
    public function openAssistant(?string $question = null): void
    {
        $this->isOpen = true;

        if ($question !== null && trim($question) !== '') {
            $this->question = $question;
            $this->sendMessage();
        }
    }

    #[On('close-assistant')]
    public function closeAssistant(): void
    {
        $this->isOpen = false;
    }

    public function toggleAssistant(): void
    {
        $this->isOpen = ! $this->isOpen;
    }

    public function render()
    {
        return view('livewire.assistant-widget');
    }
}

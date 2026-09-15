<?php

namespace App\Notifications;

use App\Models\ContentItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewResearchSummaryPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ContentItem $contentItem
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('research.show', $this->contentItem->slug);

        return (new MailMessage)
            ->subject('New Financial Research: '.$this->contentItem->title)
            ->greeting('Hello '.($notifiable->name ?? 'Learner').'!')
            ->line('A new institutional research summary has just been published on FinPulse.')
            ->line('**'.$this->contentItem->title.'**')
            ->line(Str::limit(strip_tags($this->contentItem->body), 180))
            ->action('Read Research Summary', $url)
            ->line('Stay informed with cutting-edge market analysis and financial insights.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'content_item_id' => $this->contentItem->id,
            'title' => $this->contentItem->title,
            'excerpt' => Str::limit(strip_tags($this->contentItem->body), 140),
            'url' => route('research.show', $this->contentItem->slug),
            'message' => 'New research summary: '.$this->contentItem->title,
            'type' => 'new_research',
        ];
    }
}

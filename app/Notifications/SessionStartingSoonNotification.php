<?php

namespace App\Notifications;

use App\Models\LiveSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SessionStartingSoonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public LiveSession $session
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
        $joinUrl = route('live-sessions.join', $this->session);
        $sessionTime = $this->session->scheduled_at->format('h:i A (T)');

        return (new MailMessage)
            ->subject('Reminder: Your Live Session Starts in 1 Hour — '.$this->session->title)
            ->greeting('Hello '.($notifiable->name ?? 'Learner').'!')
            ->line('Your registered live webinar/session **"'.$this->session->title.'"** will begin in approximately 1 hour at **'.$sessionTime.'**.')
            ->line('Host: '.($this->session->host->name ?? 'FinPulse Instructor'))
            ->action('Join Live Session', $joinUrl)
            ->line('Please ensure you are logged in and ready a few minutes before start time.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'live_session_id' => $this->session->id,
            'title' => $this->session->title,
            'scheduled_at' => $this->session->scheduled_at->toIso8601String(),
            'meeting_url' => route('live-sessions.join', $this->session),
            'url' => route('live-sessions.join', $this->session),
            'message' => 'Live session "'.$this->session->title.'" starts in 1 hour.',
            'type' => 'session_starting_soon',
        ];
    }
}

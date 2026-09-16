<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiringNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Subscription $subscription,
        public int $daysRemaining
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
        $url = route('pricing');
        $expiryDate = $this->subscription->ends_at->format('M d, Y');

        return (new MailMessage)
            ->subject('Important: Your FinPulse Subscription Expires in '.$this->daysRemaining.' Days')
            ->greeting('Hello '.($notifiable->name ?? 'Valued Member').'!')
            ->line('Your FinPulse Paid Subscriber membership is set to expire on **'.$expiryDate.'** (in '.$this->daysRemaining.' days).')
            ->line('To maintain uninterrupted access to our institutional masterclasses, financial research models, and live interactive webinars, renew your membership now.')
            ->action('Renew Subscription', $url)
            ->line('Thank you for being part of the FinPulse community!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'days_remaining' => $this->daysRemaining,
            'expires_at' => $this->subscription->ends_at->toIso8601String(),
            'url' => route('pricing'),
            'message' => 'Your subscription expires in '.$this->daysRemaining.' days ('.$this->subscription->ends_at->format('M d').'). Renew now to keep your premium access.',
            'type' => 'subscription_expiring',
        ];
    }
}

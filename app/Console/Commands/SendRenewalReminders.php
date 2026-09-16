<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Notifications\SubscriptionExpiringNotification;
use Illuminate\Console\Command;

class SendRenewalReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send renewal reminder notifications to users whose subscriptions expire within 3 days';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $reminderDays = (int) config('subscription.renewal_reminder_days', 3);

        $expiringSubscriptions = Subscription::where('status', 'active')
            ->where('ends_at', '>', now())
            ->where('ends_at', '<=', now()->addDays($reminderDays))
            ->with('user')
            ->get();

        $sentCount = 0;

        foreach ($expiringSubscriptions as $subscription) {
            if ($subscription->user) {
                $daysRemaining = max(1, (int) ceil(now()->diffInRealDays($subscription->ends_at)));
                $subscription->user->notify(new SubscriptionExpiringNotification($subscription, $daysRemaining));
                $sentCount++;
            }
        }

        $this->info("Sent {$sentCount} subscription renewal reminder notifications.");

        return Command::SUCCESS;
    }
}

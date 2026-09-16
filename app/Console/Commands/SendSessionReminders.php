<?php

namespace App\Console\Commands;

use App\Models\LiveSessionBooking;
use App\Notifications\SessionStartingSoonNotification;
use Illuminate\Console\Command;

class SendSessionReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send 1-hour prior reminders to users who booked upcoming live sessions';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Target sessions scheduled between now+50m and now+70m (around 1 hour window)
        $startWindow = now()->addMinutes(50);
        $endWindow = now()->addMinutes(70);

        $bookings = LiveSessionBooking::whereHas('session', function ($query) use ($startWindow, $endWindow) {
            $query->whereBetween('scheduled_at', [$startWindow, $endWindow]);
        })->with(['user', 'session.host'])->get();

        $sentCount = 0;

        foreach ($bookings as $booking) {
            if ($booking->user && $booking->session) {
                $booking->user->notify(new SessionStartingSoonNotification($booking->session));
                $sentCount++;
            }
        }

        $this->info("Sent {$sentCount} live session reminder notifications.");

        return Command::SUCCESS;
    }
}

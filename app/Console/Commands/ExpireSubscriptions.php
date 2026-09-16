<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;

class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark past-due subscriptions as expired';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $updatedCount = Subscription::where('status', 'active')
            ->where('ends_at', '<=', now())
            ->update(['status' => 'expired']);

        $this->info("Expired {$updatedCount} past-due subscriptions.");

        return Command::SUCCESS;
    }
}

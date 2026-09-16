<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

Schedule::command('subscriptions:send-reminders')->daily();
Schedule::command('subscriptions:expire')->daily();
Schedule::command('sessions:send-reminders')->everyTenMinutes();

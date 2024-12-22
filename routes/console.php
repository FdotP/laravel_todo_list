<?php

use App\Jobs\SendTaskReminderEmail;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskReminder;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::job(new SendTaskReminderEmail())->dailyAt('08:00:00');

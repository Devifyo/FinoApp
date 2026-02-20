<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Clean up old backups at 1:00 AM so the disk doesn't get full
Schedule::command('backup:clean')->daily()->at('01:00');

// Run the database backup at 1:30 AM daily
Schedule::command('backup:run --only-db')->daily()->at('01:30');
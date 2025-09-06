<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

require __DIR__.'/Shipyard/shipyard_schedule.php';

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

<?php

use App\Console\Commands\CheckAndUpdateHistoriquePrix;
use App\Console\Commands\RunScraper;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Commande de scraping
Schedule::command('app:run-scraper')->dailyAt('7:00');

// Commande de synchronisation
Schedule::command('app:check-and-update-historique-prix')->dailyAt('8:00');
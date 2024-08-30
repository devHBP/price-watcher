<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunPriceScraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-price-scraper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $output = null;
        $return_var = null;
        exec("python3 ../price-watcher-script/main.py", $output, $return_var);
    }
}

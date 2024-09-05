<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RunScraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-scraper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Vérification du cache, le script tourne t'il déja ? Si oui early return on sort
        if(Cache::get('scraper_running')){
            $this->info('Script déjà en cours');
            return;
        }

        // init du Chache ( verrou )
        Cache::put('scraper_running', true, now()->addMinutes(60));
        try{
            $venvPath = base_path('price-watcher-script/venv/bin/activate');
            $scriptPath = base_path('price-watcher-script/data_fetcher.py');
            
            $command = "source {$venvPath} && python {$scriptPath}";
    
            exec($command, $output, $returnVar);
    
            if ($returnVar === 0 ){
                $this->info('Script de scraping exécuté avec succès.');
            }
            else{
                $this->error('Erreur lors de l\'exécution du script de scraping.');
            }
    
            foreach ($output as $line) {
                $this->line($line);
            }
        }
        finally{
            // Tout s'est bien passé ? on libère le Cache.
            Cache::forget('scraper_runnig');
        }
    }
}

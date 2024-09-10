<?php

namespace App\Console\Commands;

use App\Models\HistoriquePrixProduits;
use App\Models\ProduitsConcurrents;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckAndUpdateHistoriquePrix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-and-update-historique-prix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permet la sauvegarde des tarifs relevés';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dateNow = Carbon::now()->format('Y-m-d');

        $produitsConcurrents = ProduitsConcurrents::whereDate('updated_at', $dateNow)->get();
        
        foreach ($produitsConcurrents as $produitConcurrent) {
            $enregistrementExistant = HistoriquePrixProduits::where('produit_concurrent_id', $produitConcurrent->id)
                ->whereDate('created_at', Carbon::today())
                ->first();
                
            if($enregistrementExistant){
                $enregistrementExistant->update([
                    'prix' => $produitConcurrent->prix_concurrent,
                    'updated_at' => Carbon::now(),
                ]);
            }
            else{
                HistoriquePrixProduits::create([
                    'produit_concurrent_id' => $produitConcurrent->id,
                    'prix' => $produitConcurrent->prix_concurrent,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        $this->info(('Historique des prix mis à jour'));
    }
}

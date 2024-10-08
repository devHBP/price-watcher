<?php

namespace App\Http\Controllers;

use App\Models\HistoriquePrixProduits;
use App\Models\ProduitsConcurrents;
use App\Services\VerifPrix;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function index()
    {
        $produits = ProduitsConcurrents::all();
        $averageScriptDuration = (count($produits)*4)+3;
        return view('services.index', ["averageDuration" => $averageScriptDuration]);
    }

    public function historique()
    {
        $historiques = HistoriquePrixProduits::whereDate('created_at', today())->get();
        return view('services.historique', compact('historiques'));
    }

    public function getScrapingStatus()
    {
        $latestEntry = DB::table('scraped_products')
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->first();
        
        if($latestEntry){
            return response()->json([
                'productName' => $latestEntry->designation,
                'price' => $latestEntry->prix,
                'currentIndex' => $latestEntry->position,
                'totalProducts' => $latestEntry->total,
            ]);
        }

        return response()->json([
            'productName' => 'Aucun produit traité',
            'price' => 0,
            'currentIndex' => 0,
            'totalProducts' => 0,
        ]);
    }

    /**
     * Route utilitaire, déclenche une vérification via le scraper, sur le prix/prix-minimum des ProduitsConcurrents.
     *
     * @return void
     */
    public function controleAlertePrix(VerifPrix $verifPrix)
    {
        $produitsConcurrents = ProduitsConcurrents::all();
        $alertesPrix = $verifPrix->verificationPrix($produitsConcurrents);
        
        return response()->json(["alerte" => $alertesPrix]);
    }

    public function deleteLog()
    {
        //! Route utilitaire uniquement pour but de supprimer d'ancien scraped_products log
        $logs = DB::table('scraped_products')->truncate();
    }
}
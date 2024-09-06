<?php

namespace App\Http\Controllers;

use App\Models\HistoriquePrixProduits;
use App\Models\ProduitsConcurrents;

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
}
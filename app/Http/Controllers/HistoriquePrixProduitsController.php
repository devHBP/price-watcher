<?php

namespace App\Http\Controllers;

use App\Models\HistoriquePrixProduits;
use App\Models\ProduitsConcurrents;

class HistoriquePrixProduitsController extends Controller
{
    public function index()
    {
        return view('historiques.index', ["historiques" => HistoriquePrixProduits::all()]);
    }

    public function save()
    {
        $produits = ProduitsConcurrents::all();
        foreach($produits as $produit){
            HistoriquePrixProduits::create([
                'prix'=> $produit->prix_concurrent,
                'produit_concurrent_id' => $produit->id,
                'is_below_srp' => $produit->is_below_srp,
                'is_out_of_stock' => $produit->is_out_of_stock
            ]);
        }
    }
}
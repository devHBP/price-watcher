<?php

namespace App\Http\Controllers;

use App\Models\Produits;
use App\Models\ProduitsConcurrents;

class DashboardController extends Controller
{
    public function index()
    {
        $produits = Produits::with('concurrents.concurrent')->get();

        $references = $produits->pluck('designation')->unique();
        $pvpProduits = $produits->pluck('pvp', 'designation')->toArray();

        $concurrents = $produits->pluck('concurrents.*.concurrent.nom')->flatten()->unique();

        $tableauPrix = [];

        foreach ($produits as $produit) {
            foreach($produit->concurrents as $produitConcurrent){
                $tableauPrix[$produitConcurrent->concurrent->nom][$produit->designation] = $produitConcurrent->prix_concurrent;
            }
        }

        return view('dashboard', compact('references', 'concurrents', 'tableauPrix', 'pvpProduits'));
    }
}
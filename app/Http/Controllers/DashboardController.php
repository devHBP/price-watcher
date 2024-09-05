<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\HistoriquePrixProduits;
use App\Models\Produits;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function getCategories()
    {
        return Categories::all();
    }
    
    public function getProduits(Categories $categorieId)
    {
        return Produits::where('categorie_id', $categorieId->id)->get();
    }
    
    public function getHistoriquePrix(Produits $produitId)
    {
        $productId = $produitId->id;
        $historiquePrix = HistoriquePrixProduits::whereHas('produitConcurrent', function($query) use ($productId){
            $query->where('produit_id', $productId);
        })->get();
        return $this->structuredHistoriqueData($historiquePrix);
    }

    private function structuredHistoriqueData($historiquePrix)
    {
        $structuredData = [];
        $dates = [];

        foreach ($historiquePrix as $historique) {
            $date = $historique->created_at->format('d-m-Y');
            $concurrent = $historique->produitConcurrent->concurrent->nom;
            $prix = $historique->prix;

            if (!in_array($date, $dates)) {
                $dates[] = $date;
            }
            if (!isset($structuredData[$concurrent])) {
                $structuredData[$concurrent] = [];
            }

            $structuredData[$concurrent][$date] = $prix;
        }

        return ['dates' => $dates, 'structuredData' => $structuredData];
    }

    public function indexTest()
    {
        $categories = Categories::all();
        // On selection la catégorie par default , la première
        $selectedCategorie = $categories->first();

        $produits = $selectedCategorie ? Produits::where('categorie_id', $selectedCategorie->id)->get() : [] ;

        $selectedProduit = $produits->first();
        $historiquePrix = $this->getHistoriquePrixTest($selectedProduit->id);
        return view('dashboard.test', compact('categories', 'selectedCategorie', 'produits', 'selectedProduit', 'historiquePrix'));
        
    }

    public function changeCategorie(Categories $categorie)
    {
        $categories = Categories::all();
        $selectedCategorie = $categorie;
        $produits = Produits::where('categorie_id', $selectedCategorie->id)->get();
        $selectedProduit = new Produits(['designation' => 'Produit non trouvé']);
        $historiquePrix = '';
        if(count($produits) > 1){
            $selectedProduit = $produits->first();
            $historiquePrix = $this->getHistoriquePrixTest($selectedProduit->id);
        }
        return view('dashboard.test', compact('categories', 'selectedCategorie', 'produits', 'selectedProduit', 'historiquePrix'));
    }

    public function changeProduit(Produits $produit)
    {
        $categories = Categories::all();
        $selectedProduit = $produit;
        $selectedCategorie = $produit->categorie;
        $produits = Produits::where('categorie_id', $selectedCategorie->id)->get();
        
        $historiquePrix = $this->getHistoriquePrixTest($selectedProduit->id);

        return view('dashboard.test', compact('categories', 'selectedCategorie', 'produits', 'selectedProduit', 'historiquePrix'));
    }

    public function getHistoriquePrixTest($produitId)
    {
        $dateDepart = Carbon::now()->subDays(7)->startofDay();
        $dateFin = Carbon::now()->endOfDay();

        $historique = HistoriquePrixProduits::whereHas('produitConcurrent', function($query) use ($produitId) {
            $query->where('produit_id', $produitId);
        })
            ->whereBetween('created_at', [$dateDepart, $dateFin])
            ->orderBy('created_at')
            ->get();

        return $this->structuredHistoriqueDataTest($historique);
    }

    public function structuredHistoriqueDataTest($historiques)
    {
        $dates = [];
        $structuredData = [];

        foreach ($historiques as $historique) {
            $date = $historique->created_at->format('d-m');

            if(!in_array($date, $dates)){
                $dates[] = $date;
            }

            $concurrent = $historique->produitConcurrent->concurrent->nom;
            if(!isset($structuredData[$concurrent])){
                $structuredData[$concurrent] = [];
            }

            $structuredData[$concurrent][$date] = $historique->prix;
        }

        return [
            'dates' => $dates,
            'structuredData' => $structuredData
        ];
    }

}
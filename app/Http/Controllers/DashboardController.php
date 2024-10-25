<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\HistoriquePrixProduits;
use App\Models\Produits;
use App\Models\ProduitsConcurrents;
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

        $produits = $selectedCategorie 
            ? Produits::where('categorie_id', $selectedCategorie->id)
                ->withCount('produitsConcurrents')
                ->orderBy('produits_concurrents_count', 'desc')
                ->get() 
            : [] ;

        $selectedProduit = $produits->first();
        $produitsConcurrents = ProduitsConcurrents::where('produit_id', $selectedProduit->id)->get();

        $historiquePrixFr = $this->getHistoriquePrixTest($selectedProduit->id, true);
        $variationsFr = $this->calculVariation($historiquePrixFr);

        $historiquePrixNf = $this->getHistoriquePrixTest($selectedProduit->id, false);
        $variationsNf = $this->calculVariation($historiquePrixFr);
        return view('dashboard.test', compact(
            'variationsFr',
            'categories',
            'selectedCategorie',
            'produits',
            'selectedProduit',
            'historiquePrixFr',
            'historiquePrixNf',
            'variationsNf'
        ));
    }

    public function changeCategorie(Categories $categorie)
    {
        $categories = Categories::all();
        $selectedCategorie = $categorie;
        $produits = Produits::where('categorie_id', $selectedCategorie->id)
            ->withCount('produitsConcurrents')
            ->orderBy('produits_concurrents_count', 'desc')
            ->get();
        $selectedProduit = new Produits(['designation' => 'Produit non trouvé']);
        
        $historiquePrixFr = [];
        $historiquePrixNf = [];

        if(count($produits) > 0){
            $selectedProduit = $produits->first();
            $historiquePrixFr = $this->getHistoriquePrixTest($selectedProduit->id, true);
            $historiquePrixNf = $this->getHistoriquePrixTest($selectedProduit->id, false);
        }

        $variationsFr = $this->calculVariation($historiquePrixFr); 
        $variationsNf = $this->calculVariation($historiquePrixNf);

        return view('dashboard.test', compact(
            'variationsFr',
            'categories',
            'selectedCategorie',
            'produits',
            'selectedProduit',
            'historiquePrixFr',
            'historiquePrixNf',
            'variationsNf',
        ));
    }

    public function changeProduit(Produits $produit)
    {
        $categories = Categories::all();
        $selectedProduit = $produit;
        $selectedCategorie = $produit->categorie;
        
        $produits = Produits::where('categorie_id', $selectedCategorie->id)
            ->withCount('produitsConcurrents')
            ->orderBy('produits_concurrents_count', 'desc')
            ->get();

        $historiquePrixFr = $this->getHistoriquePrixTest($selectedProduit->id, true);
        $variationsFr = $this->calculVariation($historiquePrixFr);

        $historiquePrixNf = $this->getHistoriquePrixTest($selectedProduit->id, false);
        $variationsNf = $this->calculVariation($historiquePrixFr);

        return view('dashboard.test', compact(
            'variationsFr',
            'categories',
            'selectedCategorie',
            'produits',
            'selectedProduit',
            'historiquePrixFr',
            'historiquePrixNf',
            'variationsNf'
        ));
    }

    public function getHistoriquePrixTest($produitId, $estFrancais)
    {
        $dateDepart = Carbon::now()->subDays(7)->startofDay();
        $dateFin = Carbon::now()->endOfDay();

        $historique = HistoriquePrixProduits::whereHas('produitConcurrent', function($query) use ($produitId, $estFrancais) {
            $query->where('produit_id', $produitId)
                ->whereHas('concurrent', function($query) use ($estFrancais){
                    $query->where('est_francais', $estFrancais);
                });
            ;
        })
            ->whereBetween('created_at', [$dateDepart, $dateFin])
            ->orderBy('created_at')
            ->get();
        
        return $this->structuredHistoriqueDataTest($historique);
    }

    public function structuredHistoriqueDataTest($historiques)
    {
        // 1. Calculer les 7 derniers jours (avec aujourd'hui inclus)
        $today = \Carbon\Carbon::now();
        $dates = [];
    
        for ($i = 6; $i >= 0; $i--) {
            $dates[] = $today->copy()->subDays($i)->format('d-m');
        }
    
        $structuredData = [];
    
        // 2. Construire les données structurées avec les dates disponibles
        foreach ($historiques as $historique) {
            $date = $historique->created_at->format('d-m');
            
            // Utiliser une seule fois la relation concurrent et sauvegarde dans une variable.
            $produitConcurrent = $historique->produitConcurrent;
            // Extraire le nom du concurrent
            $concurrentNom = $produitConcurrent->concurrent->nom;

            // Extraire le lien pour la derniere case de chaque concurrents. 
            $lienProduit = "{$produitConcurrent->concurrent->url}{$produitConcurrent->categorieUrlConcurrent->url_complement}{$produitConcurrent->url_produit}";
            // Initialiser le tableau pour ce concurrent s'il n'existe pas encore
            if (!isset($structuredData[$concurrentNom])) {
                $structuredData[$concurrentNom] = [];
            }
    
            // Ajouter le prix pour la date donnée pour ce concurrent
            if(!isset($structuredData[$concurrentNom][$date])){
                $structuredData[$concurrentNom][$date] = [
                    "prix" => $historique->prix,
                    "outOfStock" => $historique->is_out_of_stock,
                    "url" => $lienProduit
                ];
            }
        }
    
        // 3. S'assurer que chaque concurrent a des données pour les 7 derniers jours
        foreach ($structuredData as $concurrentNom => $data) {
            foreach ($dates as $date) {
                // Si une date est manquante pour ce concurrent, la remplir avec une valeur par défaut
                if (!isset($data[$date])) {
                    $structuredData[$concurrentNom][$date] = [
                        "prix" => '-',
                        "outOfStock" => '-',
                        "url" => '',
                    ];
                }
            }
    
            // Réordonner les données par date (pour avoir les dates dans l'ordre chronologique)
            ksort($structuredData[$concurrentNom]);
        }
    
        // 4. Si des concurrents sont complètement absents du tableau, ajouter des valeurs vides pour eux
        foreach ($historiques as $historique) {
            $concurrent = $historique->produitConcurrent->concurrent->nom;
    
            if (!isset($structuredData[$concurrent])) {
                $structuredData[$concurrent] = array_fill_keys($dates, [
                    'prix' => '-',
                    'outOfStock' => '-',
                    'url' => ''
                ]);
            }
        }
    
        // 5. Retourner les données structurées avec exactement 7 jours
        return [
            'dates' => $dates,  // Les 7 derniers jours
            'structuredData' => $structuredData  // Les données par concurrent pour ces 7 jours
        ];
    }

    public function calculVariation($historique)
    {
        $variations = [];
        $dateArray = array_reverse($historique['dates']);
        $prixPrecedent = [];
    
        foreach ($dateArray as $date) {
            foreach ($historique['structuredData'] as $concurrent => $prixData) {
                $prixActuel = $prixData[$date]["prix"] ?? null;
    
                if ($prixActuel !== null && is_numeric($prixActuel)) {
                    if (isset($prixPrecedent[$concurrent])) {
                        $prixPrecedentActuel = $prixPrecedent[$concurrent];
                        $variation = $prixActuel - $prixPrecedentActuel;
                        $variations[$concurrent][$date] = $variation;
                    } else {
                        // Pas de variation pour le premier prix
                        $variations[$concurrent][$date] = 0;
                    }
    
                    // Met à jour le prix précédent pour ce concurrent
                    $prixPrecedent[$concurrent] = $prixActuel;
                } else {
                    // Si aucun prix actuel, pas de variation à calculer
                    $variations[$concurrent][$date] = null;
                }
            }
        }
        return $variations;
    }
}
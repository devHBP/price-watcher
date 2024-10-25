<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoriesUrlConcurrents;
use App\Models\Concurrents;
use App\Models\Produits;
use App\Models\ProduitsConcurrents;
use Illuminate\Http\Request;

class ProduitsConcurrentsController extends Controller
{
    public function create()
    {
        return view('produits-concurrents.create', [ 
            "produitsConcurrents" => ProduitsConcurrents::orderBy('is_active', 'desc')->orderBy('concurrent_id', 'asc')->paginate(25)->appends(request()->query()),
            "produits" => Produits::all(),
            "categories" => Categories::all(),
            "concurrents" => Concurrents::all(),
            "categoriesUrlConcurrents" => CategoriesUrlConcurrents::all(),
        ]);
    }

    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'produit_id' => 'required|exists:produits,id',
                'concurrent_id' => 'required|exists:concurrents,id',
                'categorie_id' => 'required|exists:categories,id',
                'url_produit' => 'required|string|max:255',
                'is_active' => 'required|boolean:0,1,true,false',
            ]);
        }
        catch(\Illuminate\Validation\ValidationException $e){
            dd($e->errors());
        }
        $concurrent = Concurrents::find($validatedData['concurrent_id']);
        $urlConcurrent = $concurrent->categorieUrlConcurrent->first()->id;
        $cssDesignation = $concurrent->css_pick_designation;
        $cssPrix = $concurrent->css_pick_prix;
        $cssBadgeRupture = $concurrent->css_pick_badge_rupture;
        
        $validatedData['categorie_url_concurrent_id'] = $urlConcurrent;
        $validatedData['css_pick_designation'] = $cssDesignation;
        $validatedData['css_pick_prix'] = $cssPrix;
        $validatedData['css_pick_badge_rupture'] = $cssBadgeRupture;
        // On pars du principe que si on ajoute un produit à tracker, c'est qu'il est en stock.
        $validatedData['is_out_of_stock'] = false;

        $produitConcurrent = new ProduitsConcurrents($validatedData);
        $produitConcurrent->save();
        return redirect()->route('produits-concurrents.create')->with('success', 'Produit correctement ajouté');
    }

    public function edit(ProduitsConcurrents $produitConcurrent)
    {
        return view('produits-concurrents.edit', [
            "produitConcurrent" => $produitConcurrent,
            "produits" => Produits::all(),
            "categories" => Categories::all(),
            "concurrents" => Concurrents::all(),
            "categoriesUrlConcurrents" => CategoriesUrlConcurrents::all(),
        ]);
    }

    public function update(Request $request, ProduitsConcurrents $produitConcurrent)
    {
        try{
            $validatedData = $request->validate([
                'produit_id' => 'required|exists:produits,id',
                'concurrent_id' => 'required|exists:concurrents,id',
                'categorie_id' => 'required|exists:categories,id',
                'categorie_url_concurrent_id' => 'required|exists:categories_url_concurrents,id',
                'url_produit' => 'required|string|max:255',
                'css_pick_designation' =>'nullable|string|max:255',
                'css_pick_prix' => 'nullable|string|max:255',
                'css_pick_badge_rupture' => 'nullable|string|max:255',
                'is_out_of_stock' => 'nullable|boolean',
                'is_active' => 'required|boolean:0,1,true,false',
            ]);
        }
        catch(\Illuminate\Validation\ValidationException $e){
            dd($e->errors());
        }
        $produitConcurrent->update($validatedData);
        return redirect()->route('produits-concurrents.create')->with('success', 'Produit modifié !'); 
    }

    public function delete(ProduitsConcurrents $produitConcurrent)
    {
        $produitConcurrent->delete();
        return redirect()->route('produits-concurrents.create')->with('success', 'Produit supprimé.');
    }
}
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
            "produitsConcurrents" => ProduitsConcurrents::all(),
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
                'categorie_url_concurrent_id' => 'required|exists:categories_url_concurrents,id',
                'url_produit' => 'required|string|max:255',
                'css_pick_designation' =>'required|string|max:255',
                'css_pick_prix' => 'required|string|max:255',
            ]);
        }
        catch(\Illuminate\Validation\ValidationException $e){
            dd($e->errors());
        }

        $produitConcurrent = new ProduitsConcurrents($validatedData);
        $produitConcurrent->save();
        return redirect()->route('produits-concurrents.create')->with('success', 'Produit correctement ajouté');
    }

    public function edit(ProduitsConcurrents $produitConcurrent)
    {
        return view('produits-concurrents.edit', [
            "produit" => $produitConcurrent,
            "produits" => Produits::all(),
            "categories" => Categories::all(),
            "concurrents" => Concurrents::all(),
            "categoriesUrlConcurrents" => CategoriesUrlConcurrents::all(),
        ]);
    }

    public function update(Request $request, ProduitsConcurrents $produitConcurrent)
    {
        $validatedData = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'concurrent_id' => 'required|exists:concurrents,id',
            'categorie_id' => 'required|exists:categories,id',
            'categorie_url_concurrent_id' => 'required|exists:categories_url_concurrents,id',
            'url_produit' => 'required|string|max:255',
            'css_pick_designation' =>'required|string|max:255',
            'css_pick_prix' => 'required|string|max:255',
        ]);

        $produitConcurrent->save();
        return redirect()->route('produits-concurrents.create')->with('success', 'Produit modifié !');
    }

    public function delete(ProduitsConcurrents $produitsConcurrent)
    {
        $produitConcurrent->delete();
        return redirect()->route('produits-concurrents.create')->with('success', 'Produit supprimé.');
    }
}
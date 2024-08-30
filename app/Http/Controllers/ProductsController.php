<?php

namespace App\Http\Controllers;

use App\Models\Produits;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function create()
    {
        return view('products.create', ["produits" => Produits::all()]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'designation' => 'required|string|max:255',
            'ean' => 'required|string|max:13|unique:produits',
            'pvp' => 'required|numeric|min:0',
        ]);

        Produits::create($validatedData);
        return redirect()->route('products.create')->with('success', 'Produit ajouté avec succès !');
    }

    public function edit(Produits $produit)
    {
        return view('products.edit', ["produit" => $produit]);
    }

    public function update(Request $request, Produits $produit)
    {
        $validatedData = $request->validate([
            'designation' => 'required|string|max:255',
            'ean' => 'required|string|max:13',
            'pvp' => 'required|numeric|min:0',
        ]);

        $produit->update($validatedData);
        return redirect()->route('products.create')->with('success', 'Produit modifié !');
    }

    public function delete($id)
    {
        $produit = Produits::find($id);
        $produit->delete();
        return redirect()->route('products.create')->with('success', 'Produit supprimé avec succès !');
    }
}
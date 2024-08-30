<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function create()
    {
        return view('categories.create', [ "categories" => Categories::all() ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255'
        ]);

        Categories::create($validatedData);
        return redirect()->route('categories.create')->with('success', 'Nouvelle catégorie ajoutée !');
    }

    public function edit(Categories $categorie)
    {
        return view('categories.edit', [ "categorie" => $categorie ]);
    }

    public function update(Request $request, Categories $categorie)
    {
        $validatedData = $request->validate([
            "nom" => "required|string|max:255"
        ]);
        $categorie->update($validatedData);
        return redirect()->route('categories.create')->with('success', 'Catégorie modifié !');
    }

    public function delete(Categories $categorie)
    {
        $categorie->delete();
        return redirect()->route('categories.create')->with('success', 'Catégorie supprimée avec succès.');
    }
}
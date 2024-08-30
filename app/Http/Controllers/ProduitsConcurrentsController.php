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
        //TODO
    }

    public function edit(ProduitsConcurrents $produitConcurrent)
    {
        //TODO
    }

    public function update(Request $request, ProduitsConcurrents $produitConcurrent)
    {
        //TODO
    }

    public function delete(ProduitsConcurrents $produitsConcurrent)
    {
        //TODO
    }
}
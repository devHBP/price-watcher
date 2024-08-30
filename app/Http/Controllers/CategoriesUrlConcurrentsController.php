<?php

namespace App\Http\Controllers;

use App\Models\CategoriesUrlConcurrents;
use App\Models\Concurrents;
use Illuminate\Http\Request;

class CategoriesUrlConcurrentsController extends Controller
{
    public function create()
    {
        return view('categories-url-concurrents.create', [
            "concurrents" => Concurrents::all(),
            "categoriesUrlConcurrents" => CategoriesUrlConcurrents::all(),   
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "nom" => 'required|string|max:255',
            "url_complement" => 'required|string',
            "concurrent_id" => 'required|exists:concurrents,id'
        ]);
        CategoriesUrlConcurrents::create($validatedData);
        return redirect()->route('categories-url-concurrents.create')->with('success', 'URL complémentaire ajouté.');
    }

    public function edit(CategoriesUrlConcurrents $url)
    {
        return view('categories-url-concurrents.edit', [ "concurrents"=>Concurrents::all() , "url" => $url]);
    }

    public function update(Request $request, CategoriesUrlConcurrents $url)
    {
        $validatedData = $request->validate([
            "nom" => "string|max:255",
            "url_complement" => "string|max:255",
            "concurrent_id" => "exists:concurrents,id"
        ]);

        $url->update($validatedData);
        return redirect()->route('categories-url-concurrents.create')->with('success', 'Url complémentaire modifié.');
    }

    public function delete(CategoriesUrlConcurrents $url)
    {
        $url->delete();
        return redirect()->route('categories-url-concurrents.create')->with('success', 'Url complémentaire supprimé.');
    }
}
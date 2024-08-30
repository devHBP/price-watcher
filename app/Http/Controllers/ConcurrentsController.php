<?php

namespace App\Http\Controllers;

use App\Models\Concurrents;
use Illuminate\Http\Request;

class ConcurrentsController extends Controller
{
    public function create()
    {
        return view('concurrents.create', [ "concurrents" => Concurrents::all()]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'url' => 'required|string',
        ]);
        $concurrent = new Concurrents($validatedData);
        $concurrent->save();
        return redirect()->route('concurrents.create')->with('success', "Concurrent: {$concurrent->nom} ajouté !");
    }

    public function edit(Concurrents $concurrent)
    {
        return view('concurrents.edit', [ "concurrent" => $concurrent ]);
    }

    public function update(Request $request, Concurrents $concurrent)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'url' => 'required|string',
        ]);
        $concurrent->update($validatedData);
        return redirect()->route('concurrents.create')->with('success', 'Concurrent modifié avec succès.');
    }

    public function delete(Concurrents $concurrent)
    {
        $concurrent->delete();
        return redirect()->route('concurrents.create')->with("Concurrent supprimé.");
    }

}
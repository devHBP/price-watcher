<?php

namespace App\Http\Controllers;

use App\Models\Concurrents;
use App\Models\ProduitsConcurrents;
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
            'css_pick_designation' => 'nullable|string',
            'css_pick_prix' => 'nullable|string',
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
            'css_pick_designation' => 'nullable|string',
            'css_pick_prix' => 'nullable|string'
        ]);
        // Cas où le CSS pick vient à être rempli 
        $cssUpdates = [];
        if(!empty($request->input('css_pick_designation'))){
            $cssUpdates['css_pick_designation'] = $request->input('css_pick_designation');
        }
        if(!empty($request->input('css_pick_prix'))){
            $cssUpdates['css_pick_prix'] = $request->input('css_pick_prix');
        }
        // Si au moins un des deux champs est rempli on viens appliquer une mise à jour à la volée
        if(!empty($cssUpdates)){
            ProduitsConcurrents::where('concurrent_id', $concurrent->id)->update($cssUpdates);
        }

        $concurrent->update($validatedData);
        return redirect()->route('concurrents.create')->with('success', 'Concurrent modifié avec succès.');
    }

    public function delete(Concurrents $concurrent)
    {
        $concurrent->delete();
        return redirect()->route('concurrents.create')->with("Concurrent supprimé.");
    }

}
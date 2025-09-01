<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Devis;
use Illuminate\Http\Request;

class LotController extends Controller
{
    // Liste de tous les lots
    public function index()
    {
        $lots = Lot::with('devis')->latest()->get();
        return view('lots.index', compact('lots'));
    }

    // Formulaire pour créer un lot
    public function create()
    {
        $devis = Devis::all();
        return view('lots.create', compact('devis'));
    }

    // Stocker un lot
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'devis_id' => 'nullable|exists:devis,id',
        ]);

        Lot::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'devis_id' => $request->devis_id,
            'est_livre' => false,
        ]);

        return redirect()->route('lots.index')->with('success', 'Lot ajouté avec succès.');
    }

    // Formulaire pour modifier un lot
    public function edit(Lot $lot)
    {
        $devis = Devis::all();
        return view('lots.edit', compact('lot', 'devis'));
    }

    // Mettre à jour un lot
    public function update(Request $request, Lot $lot)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'devis_id' => 'nullable|exists:devis,id',
        ]);

        $lot->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'devis_id' => $request->devis_id,
        ]);

        return redirect()->route('lots.index')->with('success', 'Lot mis à jour avec succès.');
    }

    // Supprimer un lot
    public function destroy(Lot $lot)
    {
        $lot->delete();
        return redirect()->route('lots.index')->with('success', 'Lot supprimé avec succès.');
    }

    // Voir le détail d’un lot
    public function show(Lot $lot)
    {
        return view('lots.show', compact('lot'));
    }
}

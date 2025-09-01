<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\SousLot;
use Illuminate\Http\Request;

class SousLotController extends Controller
{
    public function index()
    {
        $sousLots = SousLot::with('lot')->get();
        return view('sous_lots.index', compact('sousLots'));
    }

    public function create()
    {
        $lots = Lot::all();
        return view('sous_lots.create', compact('lots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lot_id' => 'required|exists:lots,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        SousLot::create($request->all());
        return redirect()->route('sous_lots.index')->with('success', 'Sous-lot ajouté avec succès.');
    }

    public function edit(SousLot $sousLot)
    {
        $lots = Lot::all();
        return view('sous_lots.edit', compact('sousLot', 'lots'));
    }

    public function update(Request $request, SousLot $sousLot)
    {
        $request->validate([
            'lot_id' => 'required|exists:lots,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $sousLot->update($request->all());
        return redirect()->route('sous_lots.index')->with('success', 'Sous-lot mis à jour avec succès.');
    }

    public function destroy(SousLot $sousLot)
    {
        $sousLot->delete();
        return redirect()->route('sous_lots.index')->with('success', 'Sous-lot supprimé avec succès.');
    }
    public function show(SousLot $sousLot)
{
    // Charger le lot lié pour l'affichage
    $sousLot->load('lot');
    return view('sous_lots.show', compact('sousLot'));
}

}

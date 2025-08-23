<?php

namespace App\Http\Controllers;

use App\Models\SousLot;
use Illuminate\Http\Request;

class SousLotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sousLots = SousLot::all();
        return view('sous_lots.index', compact('sousLots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sous_lots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        SousLot::create($request->only('nom', 'description'));
        return redirect()->route('sous_lots.index')->with('success', 'Sous lot créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SousLot $sousLot)
    {
        return view('sous_lots.show', compact('sousLot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SousLot $sousLot)
    {
        return view('sous_lots.edit', compact('sousLot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SousLot $sousLot)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $sousLot->update($request->only('nom', 'description'));
        return redirect()->route('sous_lots.index')->with('success', 'Sous lot mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SousLot $sousLot)
    {
        $sousLot->delete();
        return redirect()->route('sous_lots.index')->with('success', 'Sous lot supprimé avec succès.');
    }
}

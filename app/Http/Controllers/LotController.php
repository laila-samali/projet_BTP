<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
{
    public function index()
    {
        $lots = Lot::all();
        return view('lots.index', compact('lots'));
    }

    public function create()
    {
        return view('lots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Lot::create($request->only('nom', 'description'));

        return redirect()->route('lots.index')->with('success', 'Lot créé avec succès.');
    }

    public function show(Lot $lot)
    {
        return view('lots.show', compact('lot'));
    }

    public function edit(Lot $lot)
    {
        return view('lots.edit', compact('lot'));
    }

    public function update(Request $request, Lot $lot)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $lot->update($request->only('nom', 'description'));

        return redirect()->route('lots.index')->with('success', 'Lot mis à jour avec succès.');
    }

    public function destroy(Lot $lot)
    {
        $lot->delete();
        return redirect()->route('lots.index')->with('success', 'Lot supprimé avec succès.');
    }
}

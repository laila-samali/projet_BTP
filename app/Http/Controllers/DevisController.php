<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\DevisLigne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DevisController extends Controller
{
    public function index()
    {
        $devis = Devis::with('lignes')->get();
        return view('devis.index', compact('devis'));
    }

    public function create()
    {
        return view('devis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_nom' => 'required|string',
            'client_adresse' => 'required|string',
            'client_ice' => 'nullable|string',
            'lignes.*.code_lot' => 'required|string',
            'lignes.*.description' => 'nullable|string',
            'lignes.*.prix_ht' => 'required|numeric|min:0',
        ]);

        $devis = Devis::create([
            'client_nom' => $request->client_nom,
            'client_adresse' => $request->client_adresse,
            'client_ice' => $request->client_ice,
        ]);

        $total_ht = 0;
        foreach ($request->lignes as $ligne) {
            $devis->lignes()->create($ligne);
            $total_ht += $ligne['prix_ht'];
        }

        $tva = $total_ht * 0.2; // TVA à 20%
        $total_ttc = $total_ht + $tva;

        $devis->update([
            'total_ht' => $total_ht,
            'tva' => $tva,
            'total_ttc' => $total_ttc,
        ]);

        return redirect()->route('devis.index')->with('success', 'Devis créé avec succès !');
    }
    public function edit(Devis $devis)
{
    return view('devis.edit', compact('devis'));
}
public function update(Request $request, Devis $devis)
{
    $request->validate([
        'client_nom' => 'required|string|max:255',
        'client_adresse' => 'required|string|max:255',
        'client_ice' => 'nullable|string|max:50',
        
    ]);

    $devis->update($request->all());

    return redirect()->route('devis.index')->with('success', 'Devis mis à jour avec succès.');
}

protected static function boot()
{
    parent::boot();

    static::creating(function ($devis) {
        if (empty($devis->statut)) {
            $devis->statut = 'Devis envoyé au client';
        }
    });
}
public function show($id)
{
    // Charger le devis avec ses lignes
    $devis = Devis::with('lignes')->findOrFail($id);

    return view('devis.show', compact('devis'));
}
public function destroy(Devis $devis)
{
    $devis->delete(); // supprime le devis

    return redirect()->route('devis.index')->with('success', 'Devis supprimé avec succès.');
}
public function concretiser(Devis $devis)
    {
        $devis->update([
            'statut' => 'Concrétisé'
        ]);

        return redirect()->route('devis.index')->with('success', 'Devis concrétisé avec succès.');
    }
     public function concretiserAvecUpload(Request $request, Devis $devis)
{
    $request->validate([
        'bon_commande' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
    ]);

    try {
        if ($request->hasFile('bon_commande')) {
            $file = $request->file('bon_commande');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bons_commande', $fileName, 'public');

            $devis->update([
                'statut' => 'Concrétisé',
                'bon_commande_path' => $filePath,
                'bon_commande_name' => $file->getClientOriginalName()
            ]);
        }

        return redirect()->route('devis.index')
                        ->with('success', 'Devis concrétisé avec succès et bon de commande uploadé.');

    } catch (\Exception $e) {
        return redirect()->route('devis.index')
                        ->with('error', 'Erreur lors de l\'upload du bon de commande: ' . $e->getMessage());
    }
}
public function viewBonCommande($id)
{
    $devis = Devis::findOrFail($id);

    if (!$devis->bon_commande_path || !\Storage::disk('public')->exists($devis->bon_commande_path)) {
        abort(404, 'Bon de commande introuvable');
    }

    return response()->file(storage_path('app/public/' . $devis->bon_commande_path));
}
public function downloadBonCommande($id)
{
    $devis = Devis::findOrFail($id);

    if (!$devis->bon_commande_path || !\Storage::disk('public')->exists($devis->bon_commande_path)) {
        abort(404, 'Bon de commande introuvable');
    }

    return response()->download(storage_path('app/public/' . $devis->bon_commande_path), $devis->bon_commande_name);
}

 
 

    


}


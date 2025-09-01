<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    // Affiche la liste de tous les paiements
    public function index()
    {
        // Charge les paiements avec la facture et le client pour éviter problème N+1
        $paiements = Paiement::with('facture.client')->get();

        return view('paiements.index', compact('paiements'));
    }

    // Enregistre un paiement lié à une facture
    public function store(Request $request, Facture $facture)
    {
        $validated = $request->validate([
            'date_paiement' => 'required|date',
            'type_paiement' => 'required|in:Chèque,Espèces,Virement',
            'montant' => 'required|numeric|min:0.01',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'commentaire' => 'nullable|string'
        ]);

        $paiement = new Paiement($validated);

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents_paiement', 'public');
            $paiement->document_path = $path;
        }

        $facture->paiements()->save($paiement);

        if ($facture->estTotalementPayee()) {
            $facture->update(['statut' => 'Réglé']);
        }

        return redirect()->route('factures.show', $facture)
            ->with('success', 'Paiement enregistré avec succès.');
    }

    // Supprime un paiement
    public function destroy(Facture $facture, Paiement $paiement)
    {
        $paiement->delete();

        if (!$facture->estTotalementPayee()) {
            $facture->update(['statut' => 'Réceptionné']);
        }

        return redirect()->route('factures.show', $facture)
            ->with('success', 'Paiement supprimé avec succès.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::with(['client', 'lots'])->latest()->get();
        return view('factures.index', compact('factures'));
    }

    public function create()
    {
        $clients = User::all();
        $lots_disponibles = Lot::whereHas('bonsLivraison', function($query) {
            $query->where('statut', 'Réceptionné');
        })->whereDoesntHave('factures')->get();

        return view('factures.create', compact('clients', 'lots_disponibles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:users,id',
            'date_facture' => 'required|date',
            'lots' => 'required|array',
            'lots.*' => 'exists:lots,id'
        ]);

        $facture = new Facture([
            'numero_facture' => 'F-' . date('YmdHis'),
            'client_id' => $validated['client_id'],
            'date_facture' => $validated['date_facture'],
            'statut' => 'Facturé'
        ]);

        // Calcul des totaux
        $total_ht = 0;
        $total_tva = 0;
        foreach($request->lots as $lot_id) {
            $lot = Lot::findOrFail($lot_id);
            $montant_ht = $lot->prix_ht;
            $tva = $montant_ht * 0.20; // TVA 20%
            $total_ht += $montant_ht;
            $total_tva += $tva;
        }

        $facture->total_ht = $total_ht;
        $facture->tva = $total_tva;
        $facture->total_ttc = $total_ht + $total_tva;
        $facture->save();

        // Attacher les lots
        foreach($request->lots as $lot_id) {
            $lot = Lot::findOrFail($lot_id);
            $montant_ht = $lot->prix_ht;
            $tva = $montant_ht * 0.20;
            $facture->lots()->attach($lot_id, [
                'montant_ht' => $montant_ht,
                'tva' => $tva,
                'montant_ttc' => $montant_ht + $tva
            ]);
        }

        return redirect()->route('factures.show', $facture)
            ->with('success', 'Facture créée avec succès.');
    }

    public function show(Facture $facture)
    {
        return view('factures.show', compact('facture'));
    }

    public function annuler(Request $request, Facture $facture)
    {
        $request->validate([
            'motif_annulation' => 'required|string|min:10'
        ]);

        $facture->update([
            'statut' => 'Annulé',
            'motif_annulation' => $request->motif_annulation
        ]);

        return redirect()->route('factures.index')
            ->with('success', 'Facture annulée avec succès.');
    }

    public function uploadFactureSignee(Request $request, Facture $facture)
    {
        $request->validate([
            'facture_signee' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $path = $request->file('facture_signee')->store('factures_signees', 'public');
        
        $facture->update([
            'statut' => 'Réceptionné',
            'facture_signee_path' => $path
        ]);

        return redirect()->route('factures.show', $facture)
            ->with('success', 'Facture signée uploadée avec succès.');
    }

    public function genererPDF(Facture $facture)
    {
        $pdf = PDF::loadView('factures.pdf', compact('facture'));
        return $pdf->download('facture_' . $facture->numero_facture . '.pdf');
    }
}

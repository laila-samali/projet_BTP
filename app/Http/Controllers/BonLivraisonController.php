<?php

namespace App\Http\Controllers;

use App\Models\BonLivraison;
use App\Models\Devis;
use App\Models\Lot;
use App\Models\BlLot;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BonLivraisonController extends Controller
{
    public function index()
    {
        $bls = BonLivraison::with('devis', 'lots.lot')
            ->orderBy('created_at', 'desc')
            ->get();
        $devis = Devis::all();
        $lotsNonLivres = Lot::where('est_livre', false)->get();
        return view('bl.index', compact('bls', 'devis', 'lotsNonLivres'));
    }

    public function create(Request $request)
    {
        $devis = Devis::all();
        $lotsNonLivres = Lot::where('est_livre', false)->get();
        return view('bl.create', compact('devis', 'lotsNonLivres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_bl' => 'required|unique:bons_livraison',
            'devis_id' => 'required|exists:devis,id',
            'client_nom' => 'required|string',
            'client_adresse' => 'required|string',
            'client_ice' => 'nullable|string',
            'projet' => 'required|string',
            'date_bl' => 'required|date',
            'lots' => 'required|array',
            'lots.*.id' => 'required|exists:lots,id',
            'lots.*.quantite_livree' => 'required|integer|min:1',
        ]);

        $bl = BonLivraison::create([
            'numero_bl' => $request->numero_bl,
            'devis_id' => $request->devis_id,
            'client_nom' => $request->client_nom,
            'client_adresse' => $request->client_adresse,
            'client_ice' => $request->client_ice,
            'projet' => $request->projet,
            'date_bl' => $request->date_bl,
            'statut' => 'Livré',
        ]);

        foreach ($request->lots as $lotData) {
            BlLot::create([
                'bl_id' => $bl->id,
                'lot_id' => $lotData['id'],
                'quantite_livree' => $lotData['quantite_livree'],
            ]);

            $lot = Lot::find($lotData['id']);
            $lot->est_livre = true;
            $lot->save();
        }
        dd($bls);
        // Rediriger vers la liste des BLs avec un message de succès
        return redirect()->route('bl.index')
            ->with('success', 'Bon de livraison créé avec succès. N° ' . $bl->numero_bl);
    }

    public function show($id)
    {
        $bl = BonLivraison::with('lots.lot')->findOrFail($id);
        return view('bl.show', compact('bl'));
    }

    public function generatePdf(BonLivraison $bl)
    {
        $bl->load('lots.lot', 'devis');
        $pdf = Pdf::loadView('bl.pdf', ['bl' => $bl]);
        return $pdf->download('Bon_de_livraison_' . $bl->numero_bl . '.pdf');
    }

    public function getLotsNonLivres($devis_id)
    {
        $lots = Lot::where('devis_id', $devis_id)->where('est_livre', false)->get();
        return response()->json($lots);
    }

    public function livrerLot(Request $request)
    {
        $lot = Lot::findOrFail($request->lot_id);
        $lot->est_livre = true;
        $lot->save();
        return response()->json(['success' => true]);
    }
}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bon de Livraison {{ $bl->numero_bl }}</h1>
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Client :</strong> {{ $bl->client_nom }}</p>
            <p><strong>Projet :</strong> {{ $bl->projet }}</p>
            <p><strong>Date :</strong> {{ $bl->date_bl }}</p>
            <p><strong>Statut :</strong> {{ $bl->statut }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Lots livrés</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Lot</th>
                        <th>Quantité livrée</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bl->lots as $lot)
                    <tr>
                        <td>{{ $lot->nom }}</td>
                        <td>{{ $lot->pivot->quantite_livree }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section Factures liées -->
    <div class="card mb-4">
        <div class="card-header">Factures liées</div>
        <div class="card-body">
            @php
                $factures = $bl->devis->bonLivraisons->flatMap(function($bl) {
                    return $bl->devis->factures ?? collect();
                });
            @endphp
            @if($factures->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>N° Facture</th>
                            <th>Date</th>
                            <th>Total TTC</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factures as $facture)
                        <tr>
                            <td>{{ $facture->numero_facture }}</td>
                            <td>{{ $facture->date_facture }}</td>
                            <td>{{ number_format($facture->total_ttc, 2) }} €</td>
                            <td>{{ $facture->statut }}</td>
                            <td>
                                <a href="{{ route('factures.show', $facture) }}" class="btn btn-sm btn-info">Détail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Aucune facture liée à ce bon de livraison.</p>
            @endif
        </div>
    </div>

    <!-- Section Paiements liés -->
    <div class="card mb-4">
        <div class="card-header">Paiements liés</div>
        <div class="card-body">
            @if($factures->count())
                @foreach($factures as $facture)
                    @if($facture->paiements->count())
                        <h6>Facture {{ $facture->numero_facture }}</h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($facture->paiements as $paiement)
                                <tr>
                                    <td>{{ $paiement->date_paiement }}</td>
                                    <td>{{ $paiement->type_paiement }}</td>
                                    <td>{{ number_format($paiement->montant, 2) }} €</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endforeach
            @else
                <p>Aucun paiement lié à ce bon de livraison.</p>
            @endif
        </div>
    </div>
</div>
@endsection

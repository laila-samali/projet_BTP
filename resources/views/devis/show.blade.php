@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Devis {{ $devis->id }}</h2>

    <!-- Infos client -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Informations client</h5>
            <p><strong>Nom : </strong>{{ $devis->client_nom }}</p>
            <p><strong>Adresse : </strong>{{ $devis->client_adresse }}</p>
            <p><strong>ICE : </strong>{{ $devis->client_ice ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Lignes du devis -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Lignes du devis</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Code lot</th>
                        <th>Description</th>
                        <th>Prix H.T</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devis->lignes as $index => $ligne)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ligne->code_lot }}</td>
                        <td>{{ $ligne->description }}</td>
                        <td>{{ number_format($ligne->prix_ht, 2, ',', ' ') }} MAD</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucune ligne ajoutée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Totaux -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Totaux</h5>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th>Total H.T :</th>
                        <td>{{ number_format($devis->total_ht, 2, ',', ' ') }} MAD</td>
                    </tr>
                    <tr>
                        <th>TVA (20%) :</th>
                        <td>{{ number_format($devis->tva, 2, ',', ' ') }} MAD</td>
                    </tr>
                    <tr>
                        <th>Total TTC :</th>
                        <td>{{ number_format($devis->total_ttc, 2, ',', ' ') }} MAD</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Boutons -->
    <div class="mb-3">
        <a href="{{ route('devis.index') }}" class="btn btn-secondary">Retour à la liste</a>
        <button onclick="window.print();" class="btn btn-primary">Imprimer / Export PDF</button>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Détails du Lot</h2>
    <a href="{{ route('lots.index') }}" class="btn btn-secondary mb-3">Retour</a>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $lot->id }}</td>
        </tr>
        <tr>
            <th>Nom</th>
            <td>{{ $lot->nom }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $lot->description }}</td>
        </tr>
        <tr>
            <th>Devis lié</th>
            <td>{{ $lot->devis?->client_nom ?? '-' }}</td>
        </tr>
        <tr>
            <th>Statut</th>
            <td>{{ $lot->est_livre ? 'Livré' : 'Non livré' }}</td>
        </tr>
        <tr>
            <th>Créé le</th>
            <td>{{ $lot->created_at }}</td>
        </tr>
        <tr>
            <th>Mis à jour le</th>
            <td>{{ $lot->updated_at }}</td>
        </tr>
    </table>
</div>
@endsection

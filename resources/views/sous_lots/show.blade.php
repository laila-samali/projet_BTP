@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Détails du Sous-lot</h2>
    <a href="{{ route('sous_lots.index') }}" class="btn btn-secondary mb-3">Retour</a>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $sousLot->id }}</td>
        </tr>
        <tr>
            <th>Lot</th>
            <td>{{ $sousLot->lot->nom ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nom</th>
            <td>{{ $sousLot->nom }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $sousLot->description }}</td>
        </tr>
        <tr>
            <th>Créé le</th>
            <td>{{ $sousLot->created_at }}</td>
        </tr>
        <tr>
            <th>Mis à jour le</th>
            <td>{{ $sousLot->updated_at }}</td>
        </tr>
    </table>
</div>
@endsection

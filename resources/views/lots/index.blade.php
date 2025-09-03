@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Liste des Lots</h2>
    <a href="{{ route('lots.create') }}" class="btn btn-primary mb-3">Ajouter un Lot</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Devis lié</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lots as $lot)
                <tr>
                    <td>{{ $lot->id }}</td>
                    <td>{{ $lot->nom }}</td>
                    <td>{{ $lot->description }}</td>
                    <td>{{ $lot->devis?->client_nom ?? '-' }}</td>
                    <td>{{ $lot->est_livre ? 'Livré' : 'Non livré' }}</td>
                    <td>
                        <a href="{{ route('lots.show', $lot) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('lots.edit', $lot) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('lots.destroy', $lot) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous supprimer ce lot ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

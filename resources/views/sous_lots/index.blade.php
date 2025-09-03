@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Liste des Sous-lots</h2>
    <a href="{{ route('sous_lots.create') }}" class="btn btn-primary mb-3">Ajouter un Sous-lot</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lot</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sousLots as $sousLot)
                <tr>
                    <td>{{ $sousLot->id }}</td>
                    <td>{{ $sousLot->lot->nom ?? '-' }}</td>
                    <td>{{ $sousLot->nom }}</td>
                    <td>{{ $sousLot->description }}</td>
                    <td>
                        <a href="{{ route('sous_lots.show', $sousLot) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('sous_lots.edit', $sousLot) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('sous_lots.destroy', $sousLot) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous supprimer ce sous-lot ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

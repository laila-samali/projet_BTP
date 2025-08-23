@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Sous-lots existants</h2>
    <div class="card shadow-sm rounded-4 mb-5">
        <div class="card-body">
            <a href="{{ route('sous_lots.create') }}" class="btn btn-primary rounded-pill px-4 mb-3 float-end">Ajouter un sous-lot</a>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sousLots as $sousLot)
                        <tr>
                            <td>{{ $sousLot->nom }}</td>
                            <td>{{ $sousLot->description }}</td>
                            <td class="text-end">
                                <a href="{{ route('sous_lots.edit', $sousLot) }}" class="btn btn-primary btn-sm rounded-pill px-3 me-2">Modifier</a>
                                <form action="{{ route('sous_lots.destroy', $sousLot) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="return confirm('Supprimer ce sous-lot ?')">Supprimer</button>
                                </form>
                                <a href="{{ route('sous_lots.show', $sousLot) }}" class="btn btn-link btn-sm px-2">Voir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
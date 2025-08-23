@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Détail du sous-lot</h2>
    <div class="card shadow-sm rounded-4 mb-5" style="max-width: 600px;">
        <div class="card-body">
            <div class="mb-3">
                <span class="fw-semibold">Nom :</span>
                <span>{{ $sousLot->nom }}</span>
            </div>
            <div class="mb-4">
                <span class="fw-semibold">Description :</span>
                <span>{{ $sousLot->description }}</span>
            </div>
            <a href="{{ route('sous_lots.index') }}" class="btn btn-outline-secondary me-2 rounded-pill px-4">Retour à la liste</a>
            <a href="{{ route('sous_lots.edit', $sousLot) }}" class="btn btn-primary rounded-pill px-4">Modifier</a>
        </div>
    </div>
</div>
@endsection
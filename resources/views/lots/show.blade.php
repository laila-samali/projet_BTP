@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4" style="font-family: 'Montserrat', Arial, sans-serif;">Détail du lot</h2>
    <div class="card shadow-sm rounded-4 mb-5" style="max-width: 600px;">
        <div class="card-body">
            <div class="mb-3">
                <span class="fw-semibold">Nom :</span>
                <span>{{ $lot->nom }}</span>
            </div>
            <div class="mb-4">
                <span class="fw-semibold">Description :</span>
                <span>{{ $lot->description }}</span>
            </div>
            <a href="{{ route('lots.index') }}" class="btn btn-outline-secondary me-2 rounded-pill px-4">Retour à la liste</a>
            <a href="{{ route('lots.edit', $lot) }}" class="btn btn-primary rounded-pill px-4">Modifier</a>
        </div>
    </div>
</div>
@endsection

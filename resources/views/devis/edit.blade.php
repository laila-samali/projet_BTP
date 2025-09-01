@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Modifier le Devis #{{ $devis->id }}</h2>

<form action="{{ route('devis.update', $devis->id) }}" method="POST">
    @csrf
    @method('PUT')

        <!-- Informations client -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Informations client</h5>

                <div class="mb-3">
                    <label for="client_nom" class="form-label">Nom du client</label>
                    <input type="text" name="client_nom" id="client_nom" class="form-control @error('client_nom') is-invalid @enderror" 
                           value="{{ old('client_nom', $devis->client_nom) }}" required>
                    @error('client_nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="client_adresse" class="form-label">Adresse</label>
                    <input type="text" name="client_adresse" id="client_adresse" class="form-control @error('client_adresse') is-invalid @enderror" 
                           value="{{ old('client_adresse', $devis->client_adresse) }}" required>
                    @error('client_adresse')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="client_ice" class="form-label">ICE</label>
                    <input type="text" name="client_ice" id="client_ice" class="form-control @error('client_ice') is-invalid @enderror" 
                           value="{{ old('client_ice', $devis->client_ice) }}">
                    @error('client_ice')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Boutons -->
        <div class="mb-3">
            <a href="{{ route('devis.index') }}" class="btn btn-secondary">Retour à la liste</a>
            <button type="submit" class="btn btn-primary">Mettre à jour le devis</button>
        </div>
    </form>
</div>
@endsection

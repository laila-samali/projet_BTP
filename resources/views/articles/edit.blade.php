@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Modifier Article</h2>
    <a href="{{ route('articles.index') }}" class="btn btn-secondary mb-3">Retour</a>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="sous_lot_id" class="form-label">Sous-lot</label>
            <select name="sous_lot_id" class="form-select" required>
                <option value="">-- Sélectionner un sous-lot --</option>
                @foreach($sousLots as $sousLot)
                    <option value="{{ $sousLot->id }}" {{ old('sous_lot_id', $article->sous_lot_id) == $sousLot->id ? 'selected' : '' }}>
                        {{ $sousLot->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $article->code) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $article->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="quantite" class="form-label">Quantité</label>
            <input type="number" name="quantite" class="form-control" value="{{ old('quantite', $article->quantite) }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="prix_unitaire" class="form-label">Prix Unitaire</label>
            <input type="number" name="prix_unitaire" class="form-control" value="{{ old('prix_unitaire', $article->prix_unitaire) }}" step="0.01" min="0" required>
        </div>

        <button class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection

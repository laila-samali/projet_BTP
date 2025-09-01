@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Modifier Sous-lot</h2>
    <a href="{{ route('sous_lots.index') }}" class="btn btn-secondary mb-3">Retour</a>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('sous_lots.update', $sousLot) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="lot_id" class="form-label">Lot</label>
            <select name="lot_id" class="form-select" required>
                <option value="">-- Sélectionner un lot --</option>
                @foreach($lots as $lot)
                    <option value="{{ $lot->id }}" {{ old('lot_id', $sousLot->lot_id) == $lot->id ? 'selected' : '' }}>
                        {{ $lot->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $sousLot->nom) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $sousLot->description) }}</textarea>
        </div>
        <button class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection

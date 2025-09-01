@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Ajouter un Lot</h2>
    <a href="{{ route('lots.index') }}" class="btn btn-secondary mb-3">Retour</a>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('lots.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="devis_id" class="form-label">Devis</label>
            <select name="devis_id" class="form-control">
                <option value="">-- Choisir un devis --</option>
                @foreach($devis as $devi)
                    <option value="{{ $devi->id }}" {{ old('devis_id') == $devi->id ? 'selected' : '' }}>
                        {{ $devi->client_nom }} - {{ $devi->id }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Ajouter</button>
    </form>
</div>
@endsection

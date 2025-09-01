@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Détails de l'Article</h2>
    <a href="{{ route('articles.index') }}" class="btn btn-secondary mb-3">Retour</a>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $article->id }}</td>
        </tr>
        <tr>
            <th>Sous-lot</th>
            <td>{{ $article->sousLot->nom ?? '-' }}</td>
        </tr>
        <tr>
            <th>Code</th>
            <td>{{ $article->code }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $article->description }}</td>
        </tr>
        <tr>
            <th>Quantité</th>
            <td>{{ $article->quantite }}</td>
        </tr>
        <tr>
            <th>Prix Unitaire</th>
            <td>{{ $article->prix_unitaire }}</td>
        </tr>
        <tr>
            <th>Budget</th>
            <td>{{ $article->budget }}</td>
        </tr>
        <tr>
            <th>Créé le</th>
            <td>{{ $article->created_at }}</td>
        </tr>
        <tr>
            <th>Mis à jour le</th>
            <td>{{ $article->updated_at }}</td>
        </tr>
    </table>
</div>
@endsection

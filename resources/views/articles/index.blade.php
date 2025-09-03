@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Liste des Articles</h2>
    <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Ajouter un Article</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sous-lot</th>
                <th>Code</th>
                <th>Description</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Budget</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->sousLot->nom ?? '-' }}</td>
                    <td>{{ $article->code }}</td>
                    <td>{{ $article->description }}</td>
                    <td>{{ $article->quantite }}</td>
                    <td>{{ $article->prix_unitaire }}</td>
                    <td>{{ $article->budget }}</td>
                    <td>
                        <a href="{{ route('articles.show', $article) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous supprimer cet article ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

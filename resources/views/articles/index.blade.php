@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Articles existants</h2>
    <div class="card shadow-sm rounded-4 mb-5">
        <div class="card-body">
            <a href="{{ route('articles.create') }}" class="btn btn-primary rounded-pill px-4 mb-3 float-end">Ajouter un article</a>
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
                        @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->nom }}</td>
                            <td>{{ $article->description }}</td>
                            <td class="text-end">
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-primary btn-sm rounded-pill px-3 me-2">Modifier</a>
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="return confirm('Supprimer cet article ?')">Supprimer</button>
                                </form>
                                <a href="{{ route('articles.show', $article) }}" class="btn btn-link btn-sm px-2">Voir</a>
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
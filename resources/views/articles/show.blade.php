@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Détail de l'article</h2>
    <div class="card shadow-sm rounded-4 mb-5" style="max-width: 600px;">
        <div class="card-body">
            <div class="mb-3">
                <span class="fw-semibold">Nom :</span>
                <span>{{ $article->nom }}</span>
            </div>
            <div class="mb-4">
                <span class="fw-semibold">Description :</span>
                <span>{{ $article->description }}</span>
            </div>
            <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary me-2 rounded-pill px-4">Retour à la liste</a>
            <a href="{{ route('articles.edit', $article) }}" class="btn btn-primary rounded-pill px-4">Modifier</a>
        </div>
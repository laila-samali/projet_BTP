@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Devis</h1>
    <a href="{{ route('devis.create') }}" class="btn btn-primary mb-3">Créer un devis</a>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>ICE</th>
                <th>Total HT</th>
                <th>Total TTC</th>
                <th>Statut</th>
                <th>Bon de commande</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devis as $devi)
            <tr>
                <td>{{ $devi->id }}</td>
                <td>{{ $devi->client_nom }}</td>
                <td>{{ $devi->client_ice }}</td>
                <td class="euro-value">{{ number_format($devi->total_ht, 2) }} €</td>
                <td class="euro-value">{{ number_format($devi->total_ttc, 2) }} €</td>
                
                <!-- Colonne Statut (SEULEMENT l'affichage) -->
                <td>
                    <span class="badge 
                        @if($devi->statut == 'Concrétisé') bg-success 
                        @else bg-primary 
                        @endif">
                        {{ $devi->statut }}
                    </span>
                </td>

                <!-- Colonne Bon de commande -->
                <td>
                    @if($devi->bon_commande_path)
                        <div class="btn-group">
                            <a href="{{ route('devis.view-bon-commande', $devi->id) }}" 
                               class="btn btn-sm btn-outline-primary" target="_blank">
                                Voir
                            </a>
                            <a href="{{ route('devis.download-bon-commande', $devi->id) }}" 
                               class="btn btn-sm btn-outline-secondary">
                                Télécharger
                            </a>
                        </div>
                    @else
                        <span class="text-muted">Aucun</span>
                    @endif
                </td>

                    <!-- Colonne Actions (AVEC le bouton Concrétiser et Supprimer alignés) -->
                    <td style="min-width: 260px;">
                        <div class="devis-actions">
                            <a href="{{ route('devis.show', $devi->id) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('devis.edit', $devi->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            @if($devi->statut != 'Concrétisé')
                            <button type="button" class="btn btn-success btn-sm" 
                                    data-bs-toggle="modal" data-bs-target="#uploadModal{{ $devi->id }}">
                                Concrétiser
                            </button>
                            @endif
                            <form action="{{ route('devis.destroy', $devi->id) }}" method="POST" style="display:inline; margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
            </tr>

            <!-- Modal pour l'upload du bon de commande -->
            <div class="modal fade" id="uploadModal{{ $devi->id }}" tabindex="-1" aria-labelledby="uploadModalLabel{{ $devi->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel{{ $devi->id }}">Concrétiser le Devis #{{ $devi->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('devis.concretiser.upload', $devi->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="modal-body">
                                <div class="alert alert-info">
                                    <strong>Client:</strong> {{ $devi->client_nom }}<br>
                                    <strong>Total TTC:</strong> {{ number_format($devi->total_ttc, 2) }} €
                                </div>

                                <div class="mb-3">
                                    <label for="bon_commande{{ $devi->id }}" class="form-label">Bon de commande *</label>
                                    <input type="file" class="form-control @error('bon_commande') is-invalid @enderror" 
                                           id="bon_commande{{ $devi->id }}" name="bon_commande" 
                                           accept=".pdf,.jpg,.jpeg,.png" required>
                                    <div class="form-text">Formats autorisés: PDF, JPG, JPEG, PNG (max 2MB)</div>
                                    
                                    @error('bon_commande')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Concrétiser le devis</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Inclusion de Bootstrap JS pour les modals -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
    
    .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    .btn-group .btn {
        font-size: 0.7rem;
    }
    
    form {
        display: inline-block;
        margin: 2px 0;
    }
    
    .modal-content {
        border-radius: 10px;
    }
    
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
</style>
@endsection
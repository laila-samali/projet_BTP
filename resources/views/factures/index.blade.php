@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Factures</h1>
        <a href="{{ route('factures.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle Facture
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>N° Facture</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Total HT</th>
                        <th>TVA</th>
                        <th>Total TTC</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factures as $facture)
                    <tr>
                        <td>{{ $facture->numero_facture }}</td>
                        <td>{{ $facture->client->name }}</td>
                        <td>{{ $facture->date_facture->format('d/m/Y') }}</td>
                        <td>{{ number_format($facture->total_ht, 2) }} €</td>
                        <td>{{ number_format($facture->tva, 2) }} €</td>
                        <td>{{ number_format($facture->total_ttc, 2) }} €</td>
                        <td>
                            <span class="badge bg-{{ $facture->statut === 'Réglé' ? 'success' : 
                                ($facture->statut === 'Annulé' ? 'danger' : 
                                ($facture->statut === 'Réceptionné' ? 'info' : 'warning')) }}">
                                {{ $facture->statut }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('factures.show', $facture) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('factures.pdf', $facture) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                @if($facture->statut === 'Facturé')
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                        data-bs-target="#annulerModal{{ $facture->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($factures as $facture)
    @if($facture->statut === 'Facturé')
    <!-- Modal Annulation -->
    <div class="modal fade" id="annulerModal{{ $facture->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('factures.annuler', $facture) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title">Annuler la facture {{ $facture->numero_facture }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="motif_annulation">Motif d'annulation *</label>
                            <textarea name="motif_annulation" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger">Annuler la facture</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection

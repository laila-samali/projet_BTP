@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des Paiements</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paiementModal">
            Ajouter un Paiement
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($paiements->isEmpty())
        <div class="alert alert-info">Aucun paiement disponible.</div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>N° Facture</th>
                                <th>Client</th>
                                <th>Type</th>
                                <th>Montant</th>
                                <th>Document</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paiements as $paiement)
                                <tr>
                                    <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                                    <td><a href="{{ route('factures.show', $paiement->facture) }}">{{ $paiement->facture->numero_facture }}</a></td>
                                    <td>{{ $paiement->facture->client->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $paiement->type_paiement === 'Espèces' ? 'success' : ($paiement->type_paiement === 'Chèque' ? 'info' : 'primary') }}">
                                            {{ $paiement->type_paiement }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($paiement->montant, 2, ',', ' ') }} €</td>
                                    <td>
                                        @if($paiement->document_path)
                                            <a href="{{ asset('storage/' . $paiement->document_path) }}" target="_blank" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('paiements.destroy', [$paiement->facture, $paiement]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="paiementModal" tabindex="-1" aria-labelledby="paiementModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('paiements.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="paiementModalLabel">Ajouter un Paiement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="date_paiement" class="form-label">Date de paiement</label>
          <input type="date" class="form-control" id="date_paiement" name="date_paiement" required>
        </div>
        <div class="mb-3">
          <label for="type_paiement" class="form-label">Type de paiement</label>
          <select class="form-select" id="type_paiement" name="type_paiement" required>
            <option value="">-- Sélectionnez le type --</option>
            <option value="Espèces">Espèces</option>
            <option value="Chèque">Chèque</option>
            <option value="Virement">Virement</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="montant" class="form-label">Montant</label>
          <input type="number" step="0.01" min="0.01" class="form-control" id="montant" name="montant" required>
        </div>
        <div class="mb-3">
          <label for="document" class="form-label">Document (PDF, JPG, PNG)</label>
          <input type="file" class="form-control" id="document" name="document" accept=".pdf,.jpg,.jpeg,.png">
        </div>
        <div class="mb-3">
          <label for="commentaire" class="form-label">Commentaire</label>
          <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
        </div>
        @if(isset($facture))
        <input type="hidden" name="facture_id" value="{{ $facture->id }}">
        @endif
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
      </div>
    </form>
  </div>
</div>

@endsection

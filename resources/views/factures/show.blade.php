@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Facture {{ $facture->numero_facture }}</h1>
        <div>
            <a href="{{ route('factures.pdf', $facture) }}" class="btn btn-secondary">
                <i class="fas fa-file-pdf"></i> Télécharger PDF
            </a>
            <a href="{{ route('factures.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Informations de la facture -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Client:</strong> {{ $facture->client->name }}</p>
                            <p><strong>Date:</strong> {{ $facture->date_facture->format('d/m/Y') }}</p>
                            <p><strong>Statut:</strong> 
                                <span class="badge bg-{{ $facture->statut === 'Réglé' ? 'success' : 
                                    ($facture->statut === 'Annulé' ? 'danger' : 
                                    ($facture->statut === 'Réceptionné' ? 'info' : 'warning')) }}">
                                    {{ $facture->statut }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p><strong>Total HT:</strong> {{ number_format($facture->total_ht, 2) }} €</p>
                            <p><strong>TVA:</strong> {{ number_format($facture->tva, 2) }} €</p>
                            <p><strong>Total TTC:</strong> {{ number_format($facture->total_ttc, 2) }} €</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des lots -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Lots facturés</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Lot</th>
                                    <th>Description</th>
                                    <th>Montant HT</th>
                                    <th>TVA</th>
                                    <th>Montant TTC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($facture->lots as $lot)
                                <tr>
                                    <td>{{ $lot->nom }}</td>
                                    <td>{{ $lot->description }}</td>
                                    <td>{{ number_format($lot->pivot->montant_ht, 2) }} €</td>
                                    <td>{{ number_format($lot->pivot->tva, 2) }} €</td>
                                    <td>{{ number_format($lot->pivot->montant_ttc, 2) }} €</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    @if($facture->statut === 'Facturé')
                        <!-- Upload facture signée -->
                        <form action="{{ route('factures.upload-signee', $facture) }}" method="POST" 
                              enctype="multipart/form-data" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Facture signée</label>
                                <input type="file" name="facture_signee" class="form-control" 
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Upload facture signée
                            </button>
                        </form>
                    @endif

                    <!-- Paiements -->
                    @if(in_array($facture->statut, ['Facturé', 'Réceptionné']))
                        <form action="{{ route('paiements.store', $facture) }}" method="POST" 
                              enctype="multipart/form-data" class="mb-3">
                            @csrf
                            <h6>Ajouter un paiement</h6>
                            <div class="mb-3">
                                <label class="form-label">Date de paiement</label>
                                <input type="date" name="date_paiement" class="form-control" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type de paiement</label>
                                <select name="type_paiement" class="form-control" required>
                                    <option value="Chèque">Chèque</option>
                                    <option value="Espèces">Espèces</option>
                                    <option value="Virement">Virement</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Montant</label>
                                <input type="number" name="montant" class="form-control" 
                                       step="0.01" min="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Document de paiement</label>
                                <input type="file" name="document" class="form-control" 
                                       accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                Enregistrer le paiement
                            </button>
                        </form>
                    @endif

                    <!-- Liste des paiements -->
                    @if($facture->paiements->count() > 0)
                        <h6>Paiements enregistrés</h6>
                        <ul class="list-group">
                            @foreach($facture->paiements as $paiement)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ number_format($paiement->montant, 2) }} €</strong><br>
                                        <small>{{ $paiement->type_paiement }} - 
                                              {{ $paiement->date_paiement->format('d/m/Y') }}</small>
                                    </div>
                                    <form action="{{ route('paiements.destroy', [$facture, $paiement]) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

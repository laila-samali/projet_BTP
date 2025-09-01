@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Bons de Livraison</h2>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBlModal">
        Ajouter un BL
    </button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Client</th>
                <th>N° BL</th>
                <th>Date BL</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bls as $bl)
            <tr>
                <td>{{ $bl->client_nom }}</td>
                <td>{{ $bl->numero_bl }}</td>
                <td>{{ $bl->date_bl->format('d/m/Y') }}</td>
                <td>{{ $bl->statut }}</td>
                <td>
                    <a href="{{ route('bl.show', $bl) }}" class="btn btn-info btn-sm">Détail BL</a>
                    <a href="{{ route('bl.edit', $bl) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('bl.destroy', $bl) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer BL ?')">Supprimer</button>
                    </form>
                    <a href="{{ route('bl.generatePdf', $bl) }}" class="btn btn-secondary btn-sm">Générer PDF</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal de création BL -->
<div class="modal fade" id="addBlModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('bl.store') }}" method="POST" id="blForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Bon de Livraison</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label>Numéro BL</label>
                            <input type="text" name="numero_bl" class="form-control" required>
                        </div>
                        <div class="col">
                            <label>Devis</label>
                            <select name="devis_id" class="form-control" required>
                                <option value="">-- Sélectionner un devis --</option>
                                @foreach($devis as $d)
                                    <option value="{{ $d->id }}">{{ $d->id }} - {{ $d->client_nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label>Client</label>
                            <input type="text" name="client_nom" class="form-control" required>
                        </div>
                        <div class="col">
                            <label>Adresse Client</label>
                            <input type="text" name="client_adresse" class="form-control" required>
                        </div>                        php artisan cache:clear
                        php artisan view:clear
                        
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col">
                            <label>ICE Client</label>
                            <input type="text" name="client_ice" class="form-control">
                        </div>
                        <div class="col">
                            <label></label>Projet</label>
                            <input type="text" name="projet" class="form-control" required>
                        </div>
                        <div class="col">
                            <label>Date BL</label>
                            <input type="date" name="date_bl" class="form-control" required>
                        </div>
                    </div>

                    <h5>Lots non livrés</h5>
                    <table class="table table-bordered" id="lotsTable">
                        <thead>
                            <tr>
                                <th>Nom du lot</th>
                                <th>Description</th>
                                <th>Quantité</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lotsNonLivres as $lot)
                            <tr data-id="{{ $lot->id }}">
                                <td>{{ $lot->nom }}</td>
                                <td>{{ $lot->description }}</td>
                                <td><input type="number" class="form-control qty" value="1" min="1"></td>
                                <td><button type="button" class="btn btn-sm btn-primary deliver-btn">Livrer</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h5>Lots à livrer</h5>
                    <table class="table table-bordered" id="lotsALivrerTable">
                        <thead>
                            <tr>
                                <th>Nom du lot</th>
                                <th>Description</th>
                                <th>Quantité à livrer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div id="selectedLots"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Créer BL</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectedLots = new Set();

    // Gérer le changement de devis
    document.querySelector('select[name="devis_id"]').addEventListener('change', function(e) {
        const devisId = e.target.value;
        if (devisId) {
            fetch(`/bl/lots-non-livres/${devisId}`)
                .then(response => response.json())
                .then(lots => {
                    const tbody = document.querySelector('#lotsTable tbody');
                    tbody.innerHTML = lots.map(lot => `
                        <tr data-id="${lot.id}">
                            <td>${lot.nom}</td>
                            <td>${lot.description || ''}</td>
                            <td><input type="number" class="form-control qty" value="1" min="1"></td>
                            <td><button type="button" class="btn btn-sm btn-primary deliver-btn">Livrer</button></td>
                        </tr>
                    `).join('');
                });
        }
    });

    // Gérer l'ajout d'un lot à livrer
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('deliver-btn')) {
            const row = e.target.closest('tr');
            const lotId = row.dataset.id;
            const qty = row.querySelector('.qty').value;

            if (!selectedLots.has(lotId)) {
                selectedLots.add(lotId);
                
                const lotName = row.cells[0].textContent;
                const lotDesc = row.cells[1].textContent;

                const newRow = document.querySelector('#lotsALivrerTable tbody').insertRow();
                newRow.dataset.id = lotId;
                newRow.innerHTML = `
                    <td>${lotName}</td>
                    <td>${lotDesc}</td>
                    <td>${qty}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-lot">Retirer</button>
                        <input type="hidden" name="lots[][id]" value="${lotId}">
                        <input type="hidden" name="lots[][quantite_livree]" value="${qty}">
                    </td>
                `;
            }
        }

        if (e.target.classList.contains('remove-lot')) {
            const row = e.target.closest('tr');
            const lotId = row.dataset.id;
            selectedLots.delete(lotId);
            row.remove();
        }
    });

    // Pré-remplir les informations du client quand un devis est sélectionné
    document.querySelector('select[name="devis_id"]').addEventListener('change', function(e) {
        const selectedOption = e.target.selectedOptions[0];
        if (selectedOption) {
            const clientNom = selectedOption.textContent.split(' - ')[1];
            document.querySelector('input[name="client_nom"]').value = clientNom;
        }
    });
});
</script>
@endsection

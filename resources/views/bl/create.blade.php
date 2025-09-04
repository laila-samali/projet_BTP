@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Créer un Bon de Livraison</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('bl.store') }}" method="POST" id="blForm">
            @csrf

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Numéro BL</label>
                    <input type="text" name="numero_bl" class="form-control" required>
                </div>
                <div class="col">
                    <label class="form-label">Devis</label>
                    <select name="devis_id" class="form-control" required>
                        <option value="">-- Sélectionner un devis --</option>
                        @foreach($devis as $d)
                            <option value="{{ $d->id }}">{{ $d->id }} - {{ $d->client_nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">Date BL</label>
                    <input type="date" name="date_bl" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Client</label>
                    <input type="text" name="client_nom" class="form-control" required>
                </div>
                <div class="col">
                    <label class="form-label">Adresse Client</label>
                    <input type="text" name="client_adresse" class="form-control" required>
                </div>
                <div class="col">
                    <label class="form-label">ICE Client (optionnel)</label>
                    <input type="text" name="client_ice" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Projet</label>
                <input type="text" name="projet" class="form-control" required>
            </div>

            <div class="row g-4">
                <!-- Lots non livrés -->
                <div class="col-lg-6">
                    <h5 class="mb-3">Lots non livrés</h5>
                    <table class="table table-striped align-middle" id="lotsTable">
                        <thead>
                        <tr>
                            <th>Nom du lot</th>
                            <th>Description</th>
                            <th style="width:120px;">Qté</th>
                            <th style="width:120px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lotsNonLivres as $lot)
                            <tr data-id="{{ $lot->id }}">
                                <td>{{ $lot->nom }}</td>
                                <td>{{ $lot->description }}</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm qty" value="1" min="1">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary deliver-btn">Livrer</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <small class="text-muted">Un lot ne peut être ajouté qu’une seule fois. Retirez-le de la liste de droite pour le réactiver ici.</small>
                </div>

                <!-- Lots à livrer -->
                <div class="col-lg-6">
                    <h5 class="mb-3">Lots à livrer</h5>
                    <table class="table table-striped align-middle" id="lotsALivrerTable">
                        <thead>
                        <tr>
                            <th>Nom du lot</th>
                            <th>Description</th>
                            <th style="width:140px;">Qté à livrer</th>
                            <th style="width:110px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('bl.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-success">Créer le BL</button>
            </div>
        </form>
    </div>

    <style>
        .badge { font-size: 0.85em; padding: 0.35em 0.65em; }
        .btn-sm { font-size: 0.75rem; padding: 0.25rem 0.5rem; }
        .table td, .table th { vertical-align: middle; }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const lotsTableBody = document.querySelector('#lotsTable tbody');
            const lotsALivrerTbody = document.querySelector('#lotsALivrerTable tbody');
            const form = document.getElementById('blForm');
            const devisSelect = document.querySelector('select[name="devis_id"]');
            const clientNomInput = document.querySelector('input[name="client_nom"]');

            // Ensemble des lots déjà ajoutés (id)
            const selectedSet = new Set();

            // Helper: réactive le bouton "Livrer" et l'input quantité dans la table source
            function reenableSourceRow(lotId) {
                const sourceRow = lotsTableBody.querySelector(`tr[data-id="${lotId}"]`);
                if (!sourceRow) return;
                const btn = sourceRow.querySelector('.deliver-btn');
                const qtyInput = sourceRow.querySelector('.qty');
                if (btn) {
                    btn.disabled = false;
                    btn.textContent = 'Livrer';
                    btn.classList.remove('btn-secondary');
                    btn.classList.add('btn-primary');
                }
                if (qtyInput) qtyInput.disabled = false;
            }

            // Helper: désactive le bouton "Livrer" et l'input quantité dans la table source
            function disableSourceRow(lotId) {
                const sourceRow = lotsTableBody.querySelector(`tr[data-id="${lotId}"]`);
                if (!sourceRow) return;
                const btn = sourceRow.querySelector('.deliver-btn');
                const qtyInput = sourceRow.querySelector('.qty');
                if (btn) {
                    btn.disabled = true;
                    btn.textContent = 'Ajouté';
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-secondary');
                }
                if (qtyInput) qtyInput.disabled = true;
            }

            // Préremplir nom client + charger lots non livrés quand on choisit un devis
            if (devisSelect) {
                devisSelect.addEventListener('change', async function(e){
                    // reset des sélections
                    selectedSet.clear();
                    lotsALivrerTbody.innerHTML = '';

                    // pré-remplissage client
                    const selectedOption = e.target.selectedOptions[0];
                    if (selectedOption) {
                        const parts = selectedOption.textContent.split(' - ');
                        if (parts.length > 1) clientNomInput.value = parts[1].trim();
                    }

                    const devisId = e.target.value;
                    if (!devisId) return;

                    try {
                        const resp = await fetch(`/bl/lots-non-livres/${devisId}`);
                        const lots = await resp.json();

                        lotsTableBody.innerHTML = lots.map(lot => `
                    <tr data-id="${lot.id}">
                        <td>${lot.nom}</td>
                        <td>${lot.description ?? ''}</td>
                        <td><input type="number" class="form-control form-control-sm qty" value="1" min="1"></td>
                        <td><button type="button" class="btn btn-sm btn-primary deliver-btn">Livrer</button></td>
                    </tr>
                `).join('');
                    } catch (err) {
                        console.error(err);
                        alert("Impossible de charger les lots non livrés pour ce devis.");
                    }
                });
            }

            // Ajout d'un lot (une seule fois)
            lotsTableBody.addEventListener('click', function(e){
                if(!e.target.classList.contains('deliver-btn')) return;

                const row = e.target.closest('tr');
                const lotId = row.dataset.id;
                if (selectedSet.has(lotId)) {
                    // sécurité supplémentaire si le bouton n'était pas désactivé
                    alert('Ce lot a déjà été ajouté.');
                    return;
                }

                const nom = row.children[0].textContent;
                const desc = row.children[1].textContent;
                const qty = parseInt(row.querySelector('.qty').value, 10) || 1;

                // crée la ligne dans "Lots à livrer"
                const tr = document.createElement('tr');
                tr.setAttribute('data-id', lotId);
                tr.innerHTML = `
            <td>${nom}</td>
            <td>${desc}</td>
            <td>
                <input type="number" class="form-control form-control-sm qty-to-deliver" value="${qty}" min="1">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-lot">Retirer</button>
            </td>
        `;
                lotsALivrerTbody.appendChild(tr);

                // marque comme sélectionné et désactive la ligne source
                selectedSet.add(lotId);
                disableSourceRow(lotId);
            });

            // Retirer un lot de "Lots à livrer" -> autoriser à nouveau l'ajout
            lotsALivrerTbody.addEventListener('click', function(e){
                if(!e.target.classList.contains('remove-lot')) return;
                const tr = e.target.closest('tr');
                const lotId = tr.dataset.id;
                tr.remove();
                selectedSet.delete(lotId);
                reenableSourceRow(lotId);
            });

            // Soumission : convertir la table "Lots à livrer" en inputs cachés pour Laravel
            form.addEventListener('submit', function(e){
                const rows = lotsALivrerTbody.querySelectorAll('tr');
                if (rows.length === 0) {
                    e.preventDefault();
                    alert('Veuillez sélectionner au moins un lot à livrer.');
                    return;
                }
                let i = 0;
                rows.forEach(row => {
                    const lotId = row.dataset.id;
                    const qty = parseInt(row.querySelector('.qty-to-deliver').value, 10) || 1;
                    form.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="lots[${i}][id]" value="${lotId}">
                <input type="hidden" name="lots[${i}][quantite_livree]" value="${qty}">
            `);
                    i++;
                });
            });
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Bons de Livraison</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBlModal">
        Ajouter un BL
    </button>

    <!-- Modal -->
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
                                <label>Projet</label>
                                <input type="text" name="projet" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label>Adresse Client</label>
                                <input type="text" name="client_adresse" class="form-control" required>
                            </div>
                            <div class="col">
                                <label>Date BL</label>
                                <input type="date" name="date_bl" class="form-control" required>
                            </div>
                        </div>

                        <!-- Lots non livrés -->
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

                        <!-- Lots à livrer -->
                        <h5>Lots à livrer</h5>
                        <table class="table table-bordered" id="lotsALivrerTable">
                            <thead>
                                <tr>
                                    <th>Nom du lot</th>
                                    <th>Description</th>
                                    <th>Quantité</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <input type="hidden" name="lots" id="lotsInput">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Créer BL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const lotsTable = document.querySelector('#lotsTable tbody');
    const lotsALivrerTbody = document.querySelector('#lotsALivrerTable tbody');
    const lotsInput = document.getElementById('lotsInput');

    // Ajouter un lot à livrer
    lotsTable.addEventListener('click', function(e){
        if(e.target.classList.contains('deliver-btn')){
            const row = e.target.closest('tr');
            const lotId = row.dataset.id;
            const nom = row.children[0].textContent;
            const desc = row.children[1].textContent;
            const qty = parseInt(row.querySelector('.qty').value);

            lotsALivrerTbody.innerHTML += `
                <tr data-id="${lotId}">
                    <td>${nom}</td>
                    <td>${desc}</td>
                    <td>${qty}</td>
                </tr>`;

            let lotsArray = lotsInput.value ? JSON.parse(lotsInput.value) : [];
            lotsArray.push({id: lotId, quantite_livree: qty});
            lotsInput.value = JSON.stringify(lotsArray);

            row.remove();
        }
    });

    // CSRF pour AJAX (si besoin)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });

    // Formulaire
    const form = document.getElementById('blForm');
    form.addEventListener('submit', function(e){
        if(!lotsInput.value){
            e.preventDefault();
            alert('Veuillez sélectionner au moins un lot à livrer.');
        } else {
            // Convertir JSON en inputs pour Laravel
            let lotsArray = JSON.parse(lotsInput.value);
            lotsArray.forEach((lot, i) => {
                form.insertAdjacentHTML('beforeend', 
                    `<input type="hidden" name="lots[${i}][id]" value="${lot.id}">
                     <input type="hidden" name="lots[${i}][quantite_livree]" value="${lot.quantite_livree}">`
                );
            });
        }
    });
});
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Créer un Devis</h2>

    <form action="{{ route('devis.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom du client</label>
            <input type="text" name="client_nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Adresse du client</label>
            <input type="text" name="client_adresse" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ICE du client</label>
            <input type="text" name="client_ice" class="form-control">
        </div>

        <h5>Lignes du devis</h5>
        <div id="lignes">
            <div class="ligne mb-3 row">
                <div class="col">
                    <input type="text" name="lignes[0][code_lot]" class="form-control" placeholder="Code lot" required>
                </div>
                <div class="col">
                    <input type="text" name="lignes[0][description]" class="form-control" placeholder="Description">
                </div>
                <div class="col">
                    <input type="number" name="lignes[0][prix_ht]" class="form-control" placeholder="Prix H.T" step="0.01" required>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-danger remove-ligne">Supprimer</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="addLigne">Ajouter une ligne</button>
        <br>
        <button class="btn btn-success">Créer le devis</button>
    </form>
</div>

<script>
let count = 1;
document.getElementById('addLigne').addEventListener('click', function() {
    let lignes = document.getElementById('lignes');
    let div = document.createElement('div');
    div.classList.add('ligne', 'mb-3', 'row');
    div.innerHTML = `
        <div class="col">
            <input type="text" name="lignes[${count}][code_lot]" class="form-control" placeholder="Code lot" required>
        </div>
        <div class="col">
            <input type="text" name="lignes[${count}][description]" class="form-control" placeholder="Description">
        </div>
        <div class="col">
            <input type="number" name="lignes[${count}][prix_ht]" class="form-control" placeholder="Prix H.T" step="0.01" required>
        </div>
        <div class="col">
            <button type="button" class="btn btn-danger remove-ligne">Supprimer</button>
        </div>`;
    lignes.appendChild(div);
    count++;
});

document.addEventListener('click', function(e) {
    if(e.target && e.target.classList.contains('remove-ligne')) {
        e.target.closest('.ligne').remove();
    }
});
</script>
@endsection

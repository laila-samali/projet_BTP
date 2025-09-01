@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nouvelle Facture</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('factures.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="client_id" class="form-label">Client *</label>
                            <select name="client_id" id="client_id" class="form-control" required>
                                <option value="">Sélectionnez un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date_facture" class="form-label">Date de facturation *</label>
                            <input type="date" class="form-control" id="date_facture" name="date_facture" 
                                   value="{{ old('date_facture', date('Y-m-d')) }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Lots à facturer</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Lot</th>
                                <th>Description</th>
                                <th>Prix HT</th>
                                <th>TVA</th>
                                <th>Prix TTC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lots_disponibles as $lot)
                            <tr>
                                <td>
                                    <input type="checkbox" name="lots[]" value="{{ $lot->id }}" class="lot-checkbox">
                                </td>
                                <td>{{ $lot->nom }}</td>
                                <td>{{ $lot->description }}</td>
                                <td>{{ number_format($lot->prix_ht, 2) }} €</td>
                                <td>{{ number_format($lot->prix_ht * 0.20, 2) }} €</td>
                                <td>{{ number_format($lot->prix_ht * 1.20, 2) }} €</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('factures.index') }}" class="btn btn-secondary me-2">Annuler</a>
            <button type="submit" class="btn btn-primary">Créer la facture</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('select-all').addEventListener('change', function() {
    document.querySelectorAll('.lot-checkbox').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
@endpush
@endsection

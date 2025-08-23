@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4" style="font-family: 'Montserrat', Arial, sans-serif;">Modifier le lot</h2>
    <div class="card shadow-sm rounded-4 mb-5">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('lots.update', $lot) }}" method="POST" class="row g-3 align-items-center">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nom du lot</label>
                    <input type="text" name="nom" value="{{ old('nom', $lot->nom) }}" required class="form-control rounded-pill">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Description</label>
                    <input type="text" name="description" value="{{ old('description', $lot->description) }}" class="form-control rounded-pill">
                </div>
                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

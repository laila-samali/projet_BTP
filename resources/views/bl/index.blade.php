@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Bons de Livraison</h1>

        <a href="{{ route('bl.create') }}" class="btn btn-primary mb-3">
            Créer un BL
        </a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-striped">
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
                    <td>{{ $bl->date_bl ? \Carbon\Carbon::parse($bl->date_bl)->format('d/m/Y') : '-' }}</td>
                    <td>
                    <span class="badge @if($bl->statut === 'Livré') bg-success @else bg-primary @endif">
                        {{ $bl->statut }}
                    </span>
                    </td>
                    <td style="min-width: 260px;">
                        <div class="bl-actions">
                            <a href="{{ route('bl.show', $bl) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('bl.edit', $bl) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="{{ route('bl.generatePdf', $bl) }}" class="btn btn-outline-secondary btn-sm" target="_blank">PDF</a>
                            <form action="{{ route('bl.destroy', $bl) }}" method="POST" style="display:inline; margin:0;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce BL ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

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

        .bl-actions {
            display: inline-flex;
            flex-wrap: wrap;
            gap: .25rem;
            align-items: center;
        }

        form {
            display: inline-block;
            margin: 2px 0;
        }
    </style>
@endsection

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bon de Livraison {{ $bl->numero_bl }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Bon de Livraison</h2>
    <p><strong>N° BL:</strong> {{ $bl->numero_bl }}</p>
    <p><strong>Client:</strong> {{ $bl->client_nom }}</p>
    <p><strong>Adresse:</strong> {{ $bl->client_adresse }}</p>
    <p><strong>Date BL:</strong> {{ $bl->date_bl->format('d/m/Y') }}</p>

    <h3>Lots Livrés</h3>
    <table>
        <tr>
            <th>Nom du lot</th>
            <th>Description</th>
            <th>Quantité livrée</th>
        </tr>
        @foreach($bl->lots as $blLot)
        <tr>
            <td>{{ $blLot->lot->nom }}</td>
            <td>{{ $blLot->lot->description }}</td>
            <td>{{ $blLot->pivot->quantite_livree }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>

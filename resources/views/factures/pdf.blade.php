<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture {{ $facture->numero_facture }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .company-info {
            margin-bottom: 30px;
        }
        .client-info {
            margin-bottom: 30px;
        }
        .facture-details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .total-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE</h1>
    </div>

    <div class="company-info">
        <h2>Votre Entreprise</h2>
        <p>Adresse de l'entreprise<br>
           Code postal, Ville<br>
           Téléphone: XX XX XX XX XX<br>
           Email: contact@entreprise.com</p>
    </div>

    <div class="client-info">
        <strong>Facturé à:</strong><br>
        {{ $facture->client->name }}<br>
        {{ $facture->client->adresse }}<br>
        @if($facture->client->ice)
        ICE: {{ $facture->client->ice }}
        @endif
    </div>

    <div class="facture-details">
        <strong>Facture N°:</strong> {{ $facture->numero_facture }}<br>
        <strong>Date:</strong> {{ $facture->date_facture->format('d/m/Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th width="100">Montant HT</th>
                <th width="100">TVA</th>
                <th width="100">Montant TTC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facture->lots as $lot)
            <tr>
                <td>
                    <strong>{{ $lot->nom }}</strong><br>
                    {{ $lot->description }}
                </td>
                <td>{{ number_format($lot->pivot->montant_ht, 2) }} €</td>
                <td>{{ number_format($lot->pivot->tva, 2) }} €</td>
                <td>{{ number_format($lot->pivot->montant_ttc, 2) }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="total-line">
            <span>Total HT:</span>
            <strong>{{ number_format($facture->total_ht, 2) }} €</strong>
        </div>
        <div class="total-line">
            <span>TVA (20%):</span>
            <strong>{{ number_format($facture->tva, 2) }} €</strong>
        </div>
        <div class="total-line">
            <span>Total TTC:</span>
            <strong>{{ number_format($facture->total_ttc, 2) }} €</strong>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="footer">
        <p>
            Facture à régler sous 30 jours.<br>
            En cas de retard de paiement, une pénalité de 3 fois le taux d'intérêt légal sera appliquée.
        </p>
    </div>
</body>
</html>

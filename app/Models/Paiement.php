<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'facture_id',
        'date_paiement',
        'type_paiement',
        'document_path',
        'montant',
        'commentaire'
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'montant' => 'decimal:2'
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}

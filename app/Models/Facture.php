<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_facture',
        'client_id',
        'date_facture',
        'total_ht',
        'tva',
        'total_ttc',
        'statut',
        'motif_annulation',
        'facture_signee_path'
    ];

    protected $casts = [
        'date_facture' => 'date',
        'total_ht' => 'decimal:2',
        'tva' => 'decimal:2',
        'total_ttc' => 'decimal:2'
    ];

    // Relations
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function lots()
    {
        return $this->belongsToMany(Lot::class, 'facture_lots')
            ->withPivot(['montant_ht', 'tva', 'montant_ttc'])
            ->withTimestamps();
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // Méthodes utilitaires
    public function getMontantResteAPayer()
    {
        return $this->total_ttc - $this->paiements->sum('montant');
    }

    public function estTotalementPayee()
    {
        return $this->getMontantResteAPayer() <= 0;
    }
}

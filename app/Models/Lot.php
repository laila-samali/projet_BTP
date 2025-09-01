<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lot extends Model
{
    use HasFactory;

 protected $fillable = ['nom', 'description', 'devis_id', 'est_livre'];


    protected $casts = [
        'est_livre' => 'boolean',
    ];

    // Relation avec le devis
    public function devis(): BelongsTo
    {
        return $this->belongsTo(Devis::class);
    }

    // Relation avec les bons de livraison
    public function bonsLivraison()
    {
        return $this->belongsToMany(BonLivraison::class, 'bl_lots', 'lot_id', 'bl_id')
                    ->withPivot('quantite_livree')
                    ->withTimestamps();
    }

        // Relation avec les factures
        public function factures()
        {
            return $this->belongsToMany(Facture::class, 'facture_lots')
                ->withPivot(['montant_ht', 'tva', 'montant_ttc'])
                ->withTimestamps();
        }
}
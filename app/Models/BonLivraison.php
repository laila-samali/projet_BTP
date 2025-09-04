<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonLivraison extends Model
{
    use HasFactory;

    protected $table = 'bon_livraisons';

    protected $fillable = [
        'numero_bl',
        'devis_id',
        'client_nom',
        'client_adresse',
        'client_ice',
        'projet',
        'date_bl',
        'statut',
        'bl_signe_path'
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    public function lots()
    {
        return $this->belongsToMany(Lot::class, 'bl_lots')
             ->withPivot('quantite_livree')
             ->withTimestamps();
    }
}

<?php

// app/Models/BlLot.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlLot extends Model
{
    use HasFactory;

    protected $table = 'bl_lots';
    
    protected $fillable = [
        'bl_id',
        'lot_id',
        'quantite_livree'
    ];

    public function bonLivraison()
    {
        return $this->belongsTo(BonLivraison::class, 'bl_id');
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }
}
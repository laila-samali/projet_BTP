<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevisLigne extends Model
{
    protected $fillable = ['devis_id', 'code_lot', 'description', 'prix_ht'];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }
}

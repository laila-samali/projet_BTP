<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    protected $fillable = [
        'client_nom', 'client_adresse', 'client_ice',
        'total_ht', 'tva', 'total_ttc', 'statut',
        'bon_commande_path', 'bon_commande_name' // Ajout des champs bon de commande
    ];

    public function lignes()
    {
        return $this->hasMany(DevisLigne::class);
    }

    // Méthode pour vérifier si un bon de commande existe
    public function hasBonCommande()
    {
        return !is_null($this->bon_commande_path);
    }

    // Méthode pour obtenir l'URL du bon de commande
    public function getBonCommandeUrl()
    {
        return asset('storage/' . $this->bon_commande_path);
    }
     public function lots(): HasMany
    {
        return $this->hasMany(Lot::class);
    }

    // Relation avec les bons de livraison
    public function bonLivraisons(): HasMany
    {
        return $this->hasMany(BonLivraison::class);
    }

    // Récupérer les lots non livrés
    public function lotsNonLivres()
    {
        return $this->lots()->where('est_livre', false);
    }
}
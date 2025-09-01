<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotController;
use App\Http\Controllers\SousLotController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\BonLivraisonController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\PaiementController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ici sont définies toutes les routes de l'application.
|
*/

// Page d'accueil : redirige vers la liste des lots
Route::get('/', [LotController::class, 'index'])->name('home');

// Routes CRUD pour les Lots
Route::resource('lots', LotController::class);

// Routes CRUD pour les Sous-lots
Route::resource('sous_lots', SousLotController::class);

// Routes CRUD pour les Articles
Route::resource('articles', ArticleController::class);

// Route optionnelle : lister les articles d'un sous-lot spécifique
Route::get('sous_lots/{sous_lot}/articles', [ArticleController::class, 'indexBySousLot'])
    ->name('sous_lots.articles');
// Liste des devis
Route::get('/devis', [DevisController::class, 'index'])->name('devis.index');

// Créer un nouveau devis
Route::get('/devis/create', [DevisController::class, 'create'])->name('devis.create');
Route::post('/devis', [DevisController::class, 'store'])->name('devis.store');

// Voir un devis
Route::get('/devis/{devis}', [DevisController::class, 'show'])->name('devis.show');

// Modifier un devis
Route::get('/devis/{devis}/edit', [DevisController::class, 'edit'])->name('devis.edit');
Route::put('/devis/{devis}', [DevisController::class, 'update'])->name('devis.update');
Route::patch('devis/{devis}/concretiser', [DevisController::class, 'concretiser'])->name('devis.concretiser');

// Supprimer un devis
Route::delete('/devis/{devis}', [DevisController::class, 'destroy'])->name('devis.destroy');
Route::delete('/devis/{devis}', [DevisController::class, 'destroy'])->name('devis.destroy');

Route::patch('devis/{devis}/concretiser-upload', [DevisController::class, 'concretiserAvecUpload'])
     ->name('devis.concretiser.upload');
     
Route::get('/devis/view-bon-commande/{id}', [DevisController::class, 'viewBonCommande'])
    ->name('devis.view-bon-commande');

Route::get('/devis/download-bon-commande/{id}', [DevisController::class, 'downloadBonCommande'])
    ->name('devis.download-bon-commande');


// Route resource (gère index, create, store, show, edit, update, destroy)
Route::resource('bl', BonLivraisonController::class);

// Génération PDF
Route::get('/bl/{bl}/generate-pdf', [BonLivraisonController::class, 'generatePdf'])->name('bl.generatePdf');

// Routes AJAX
Route::get('/bl/lots-non-livres/{devis}', [BonLivraisonController::class, 'getLotsNonLivres'])->name('bl.lots-non-livres');
Route::post('/bl/livrer-lot', [BonLivraisonController::class, 'livrerLot'])->name('bl.livrer-lot');

// Routes pour les Factures
Route::resource('factures', FactureController::class);
Route::patch('/factures/{facture}/annuler', [FactureController::class, 'annuler'])->name('factures.annuler');
Route::post('/factures/{facture}/upload-signee', [FactureController::class, 'uploadFactureSignee'])->name('factures.upload-signee');
Route::get('/factures/{facture}/pdf', [FactureController::class, 'genererPDF'])->name('factures.pdf');

// Routes pour les Paiements
Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');
Route::post('/factures/{facture}/paiements', [PaiementController::class, 'store'])->name('paiements.store');
Route::delete('/factures/{facture}/paiements/{paiement}', [PaiementController::class, 'destroy'])->name('paiements.destroy');
Route::resource('paiements', PaiementController::class)->only(['index', 'store', 'destroy']);

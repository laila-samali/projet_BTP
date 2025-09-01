<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\PaiementController;

// Routes pour les factures
Route::resource('factures', FactureController::class);
Route::patch('/factures/{facture}/annuler', [FactureController::class, 'annuler'])->name('factures.annuler');
Route::post('/factures/{facture}/upload-signee', [FactureController::class, 'uploadFactureSignee'])->name('factures.upload-signee');
Route::get('/factures/{facture}/pdf', [FactureController::class, 'genererPDF'])->name('factures.pdf');

// Routes pour les paiements
Route::post('/factures/{facture}/paiements', [PaiementController::class, 'store'])->name('paiements.store');
Route::delete('/factures/{facture}/paiements/{paiement}', [PaiementController::class, 'destroy'])->name('paiements.destroy');

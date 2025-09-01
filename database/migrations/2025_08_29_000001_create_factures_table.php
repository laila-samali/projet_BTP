<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('numero_facture')->unique();
            $table->foreignId('client_id')->constrained('users');
            $table->date('date_facture');
            $table->decimal('total_ht', 10, 2);
            $table->decimal('tva', 10, 2);
            $table->decimal('total_ttc', 10, 2);
            $table->string('statut')->default('Facturé');
            $table->string('motif_annulation')->nullable();
            $table->string('facture_signee_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factures');
    }
};

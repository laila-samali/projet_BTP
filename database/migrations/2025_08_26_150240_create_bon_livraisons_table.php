<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('bons_livraison', function (Blueprint $table) {
        $table->id();
        $table->string('numero_bl')->unique();
        $table->foreignId('devis_id')->constrained();
        $table->string('client_nom');
        $table->text('client_adresse');
        $table->string('client_ice')->nullable();
        $table->string('projet');
        $table->date('date_bl');
        $table->string('statut')->default('Livré');
        $table->string('bl_signe_path')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bons_livraison');
    }
};

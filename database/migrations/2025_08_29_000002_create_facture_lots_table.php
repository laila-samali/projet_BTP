<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('facture_lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facture_id')->constrained()->onDelete('cascade');
            $table->foreignId('lot_id')->constrained()->onDelete('cascade');
            $table->decimal('montant_ht', 10, 2);
            $table->decimal('tva', 10, 2);
            $table->decimal('montant_ttc', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facture_lots');
    }
};

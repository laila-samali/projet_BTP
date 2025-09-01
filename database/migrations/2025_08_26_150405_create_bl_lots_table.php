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
    Schema::create('bl_lots', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bl_id')->constrained('bons_livraison')->onDelete('cascade');
        $table->foreignId('lot_id')->constrained()->onDelete('cascade');
        $table->integer('quantite_livree')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bl_lots');
    }
};

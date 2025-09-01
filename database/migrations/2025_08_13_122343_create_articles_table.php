<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('articles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sous_lot_id')->constrained()->onDelete('cascade');
    $table->string('code');
    $table->string('description')->nullable();
    $table->integer('quantite')->default(0);
    $table->decimal('prix_unitaire', 10, 2)->default(0);
    $table->decimal('budget', 10, 2)->default(0);
    $table->decimal('realisation', 10, 2)->default(0);
    $table->decimal('marge_estimee', 10, 2)->default(0);
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

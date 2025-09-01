<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('sous_lots', function (Blueprint $table) {
    $table->id();
    $table->foreignId('lot_id')->constrained()->onDelete('cascade');
    $table->string('nom');
    $table->text('description')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('sous_lots');
    }
};

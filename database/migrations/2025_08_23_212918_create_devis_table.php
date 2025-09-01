<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->string('client_nom');
            $table->string('client_adresse');
            $table->string('client_ice')->nullable();
            $table->decimal('total_ht', 15, 2)->default(0);
            $table->decimal('tva', 15, 2)->default(0);
            $table->decimal('total_ttc', 15, 2)->default(0);
            $table->string('statut')->default('Devis envoyé au client'); // Ajout du statut
            $table->timestamps();
        });

        Schema::create('devis_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devis_id')->constrained()->onDelete('cascade');
            $table->string('code_lot');
            $table->string('description')->nullable();
            $table->decimal('prix_ht', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devis_lignes');
        Schema::dropIfExists('devis');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->string('bon_commande_path')->nullable()->after('statut');
            $table->string('bon_commande_name')->nullable()->after('bon_commande_path');
        });
    }

    public function down(): void
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->dropColumn(['bon_commande_path', 'bon_commande_name']);
        });
    }
};
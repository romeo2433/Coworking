<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('option_reservation', function (Blueprint $table) {
            // Clé étrangère vers la table options (assurez-vous que la table ne s'appelle pas juste "option")
            $table->foreignId('id_option')->constrained('options', 'id_option')->onDelete('cascade');

            // Clé étrangère vers la table reservations
            $table->foreignId('id_reservation')->constrained('reservations', 'id_reservation')->onDelete('cascade');

            // Définition de la clé primaire composite
            $table->primary(['id_option', 'id_reservation']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_reservation');
    }
};

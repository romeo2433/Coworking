<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('status_reservation', function (Blueprint $table) {
            // Clé étrangère vers reservations
            $table->foreignId('id_reservation')->constrained('reservations', 'id_reservation')->onDelete('cascade');

            // Clé étrangère vers status (renommée en statuses pour éviter un conflit avec un mot réservé)
            $table->foreignId('id_status')->constrained('statuses', 'id_status')->onDelete('cascade');

            // Timestamp pour suivre les changements de statut
            $table->timestamp('date_status')->useCurrent();

            // Définition de la clé primaire composite
            $table->primary(['id_reservation', 'id_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_reservation');
    }
};

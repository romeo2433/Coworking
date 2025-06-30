<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('id_reservation');
            $table->string('reference', 50);
            $table->date('date_reservation');
            $table->time('heure_debut');
            $table->integer('duree');
            $table->decimal('total', 15, 2)->nullable();
            
            // Ajout de la colonne id_espace avant la contrainte
            $table->integer('id_espace'); 
            $table->foreign('id_espace')->references('id_espace')->on('espaces')->onDelete('cascade');
        
            // Correction de la clé étrangère id_utilisateur
            $table->foreignId('id_utilisateur')->constrained('utilisateurs', 'id_utilisateur')->onDelete('cascade');
            $table->timestamps(); // Ajoute created_at et updated_at automatiquement
            
        });
        
        
        
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

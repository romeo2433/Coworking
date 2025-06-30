<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('id_utilisateur');
            $table->string('numero', 100)->unique()->nullable();
            $table->string('mdp', 255)->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->integer('id_profil'); // Utiliser INTEGER pour correspondre à profils
            $table->foreign('id_profil')->references('id_profil')->on('profils')->onDelete('cascade');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};

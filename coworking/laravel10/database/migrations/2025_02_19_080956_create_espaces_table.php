<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('espaces', function (Blueprint $table) {
            $table->integer('id_espace')->primary(); // Définir explicitement la clé primaire
            $table->string('nom', 100)->unique();
            $table->decimal('prix_heure', 15, 2)->check('prix_heure >= 0');                    
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('espaces');
    }
};

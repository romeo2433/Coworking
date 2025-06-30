<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->integer('id_profil')->primary(); // Définir explicitement la clé primaire
            $table->string('profil', 50)->unique();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};

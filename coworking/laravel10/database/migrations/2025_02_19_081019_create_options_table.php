<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id('id_option'); // Clé primaire auto-incrémentée
            $table->string('code', 50)->unique();
            $table->string('option', 100);
            $table->decimal('prix', 15, 2)->check('prix >= 0'); // Contrainte de validation
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('configurations_horaires', function (Blueprint $table) {
            $table->id('id_conf');
            $table->integer('heure_debut');
            $table->integer('heure_fin');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurations_horaires');
    }
};

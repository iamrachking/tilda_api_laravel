<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->string('userId');
            $table->string('recipeId');
            $table->timestamps();

            // Contrainte unique pour éviter les doublons
            $table->unique(['userId', 'recipeId']);
            
            // Index pour améliorer les performances
            $table->index('userId');
            $table->index('recipeId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};

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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('commentId')->unique();
            $table->string('userId');
            $table->string('recipeId');
            $table->text('text');
            $table->integer('likes')->default(0);
            $table->timestamps();

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
        Schema::dropIfExists('comments');
    }
};

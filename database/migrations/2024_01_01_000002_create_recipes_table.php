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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('recipeId')->unique();
            $table->string('title');
            $table->string('imageUrl')->nullable();
            $table->text('description');
            $table->json('ingredients');
            $table->json('steps');
            $table->string('categoryId');
            $table->string('chefId');
            $table->string('duration');
            $table->integer('likesCount')->default(0);
            $table->integer('commentsCount')->default(0);
            $table->integer('favoritesCount')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index('categoryId');
            $table->index('chefId');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};

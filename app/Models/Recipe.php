<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipeId',
        'title',
        'imageUrl',
        'description',
        'ingredients',
        'steps',
        'categoryId',
        'chefId',
        'duration',
        'likesCount',
        'commentsCount',
        'favoritesCount',
        'rating'
    ];

    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
        'likesCount' => 'integer',
        'commentsCount' => 'integer',
        'favoritesCount' => 'integer',
        'rating' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec le chef (utilisateur)
     */
    public function chef()
    {
        return $this->belongsTo(User::class, 'chefId', 'userId');
    }

    /**
     * Relation avec la catégorie
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'categoryId');
    }

    /**
     * Relation avec les favoris
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'recipeId', 'recipeId');
    }

    /**
     * Relation avec les likes
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'recipeId', 'recipeId');
    }

    /**
     * Relation avec les commentaires
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'recipeId', 'recipeId');
    }
}

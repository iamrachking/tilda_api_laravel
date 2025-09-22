<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'recipeId'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    /**
     * Relation avec la recette
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipeId', 'recipeId');
    }
}

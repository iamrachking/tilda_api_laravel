<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryId',
        'name',
        'imageUrl'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec les recettes
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'categoryId', 'categoryId');
    }
}

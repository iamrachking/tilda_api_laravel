<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    /**
     * Liste des recettes favorites de l'utilisateur
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $favorites = Favorite::where('userId', $user->userId)
            ->with(['recipe.chef', 'recipe.category'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $favorites
        ]);
    }

    /**
     * Ajouter une recette aux favoris
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipeId' => 'required|string|exists:recipes,recipeId',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // Vérifier si la recette est déjà en favori
        $existingFavorite = Favorite::where('userId', $user->userId)
            ->where('recipeId', $request->recipeId)
            ->first();

        if ($existingFavorite) {
            return response()->json([
                'success' => false,
                'message' => 'Cette recette est déjà dans vos favoris'
            ], 409);
        }

        $favorite = Favorite::create([
            'userId' => $user->userId,
            'recipeId' => $request->recipeId,
        ]);

        // Mettre à jour le compteur de favoris
        Recipe::where('recipeId', $request->recipeId)
            ->increment('favoritesCount');

        return response()->json([
            'success' => true,
            'message' => 'Recette ajoutée aux favoris',
            'data' => $favorite->load(['recipe.chef', 'recipe.category'])
        ], 201);
    }

    /**
     * Supprimer une recette des favoris
     */
    public function destroy(Request $request, $recipeId)
    {
        $user = $request->user();

        $favorite = Favorite::where('userId', $user->userId)
            ->where('recipeId', $recipeId)
            ->first();

        if (!$favorite) {
            return response()->json([
                'success' => false,
                'message' => 'Recette non trouvée dans vos favoris'
            ], 404);
        }

        $favorite->delete();

        // Mettre à jour le compteur de favoris
        Recipe::where('recipeId', $recipeId)
            ->decrement('favoritesCount');

        return response()->json([
            'success' => true,
            'message' => 'Recette supprimée des favoris'
        ]);
    }

    /**
     * Vérifier si une recette est en favori
     */
    public function check(Request $request, $recipeId)
    {
        $user = $request->user();

        $isFavorite = Favorite::where('userId', $user->userId)
            ->where('recipeId', $recipeId)
            ->exists();

        return response()->json([
            'success' => true,
            'data' => ['isFavorite' => $isFavorite]
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    /**
     * Liste des recettes likées par l'utilisateur
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $likes = Like::where('userId', $user->userId)
            ->with(['recipe.chef', 'recipe.category'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $likes
        ]);
    }

    /**
     * Liker une recette
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

        // Vérifier si la recette est déjà likée
        $existingLike = Like::where('userId', $user->userId)
            ->where('recipeId', $request->recipeId)
            ->first();

        if ($existingLike) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà liké cette recette'
            ], 409);
        }

        $like = Like::create([
            'userId' => $user->userId,
            'recipeId' => $request->recipeId,
        ]);

        // Mettre à jour le compteur de likes
        Recipe::where('recipeId', $request->recipeId)
            ->increment('likesCount');

        return response()->json([
            'success' => true,
            'message' => 'Recette likée',
            'data' => $like->load(['recipe.chef', 'recipe.category'])
        ], 201);
    }

    /**
     * Unliker une recette
     */
    public function destroy(Request $request, $recipeId)
    {
        $user = $request->user();

        $like = Like::where('userId', $user->userId)
            ->where('recipeId', $recipeId)
            ->first();

        if (!$like) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'avez pas liké cette recette'
            ], 404);
        }

        $like->delete();

        // Mettre à jour le compteur de likes
        Recipe::where('recipeId', $recipeId)
            ->decrement('likesCount');

        return response()->json([
            'success' => true,
            'message' => 'Like supprimé'
        ]);
    }

    /**
     * Vérifier si une recette est likée
     */
    public function check(Request $request, $recipeId)
    {
        $user = $request->user();

        $isLiked = Like::where('userId', $user->userId)
            ->where('recipeId', $recipeId)
            ->exists();

        return response()->json([
            'success' => true,
            'data' => ['isLiked' => $isLiked]
        ]);
    }
}

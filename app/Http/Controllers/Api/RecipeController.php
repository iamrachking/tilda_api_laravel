<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    /**
     * Liste de toutes les recettes avec pagination
     */
    public function index(Request $request)
    {
        $query = Recipe::with(['chef', 'category']);

        // Filtre par catégorie
        if ($request->has('categoryId')) {
            $query->where('categoryId', $request->categoryId);
        }

        // Recherche par titre
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Tri
        $sortBy = $request->get('sortBy', 'created_at');
        $sortOrder = $request->get('sortOrder', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $recipes = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $recipes
        ]);
    }

    /**
     * Créer une nouvelle recette
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|array',
            'steps' => 'required|array',
            'categoryId' => 'required|string|exists:categories,categoryId',
            'duration' => 'required|string',
            'imageUrl' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        $recipe = Recipe::create([
            'recipeId' => Str::uuid(),
            'title' => $request->title,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
            'steps' => $request->steps,
            'categoryId' => $request->categoryId,
            'chefId' => $user->userId,
            'duration' => $request->duration,
            'imageUrl' => $request->imageUrl,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recette créée avec succès',
            'data' => $recipe->load(['chef', 'category'])
        ], 201);
    }

    /**
     * Afficher une recette spécifique
     */
    public function show($recipeId)
    {
        $recipe = Recipe::where('recipeId', $recipeId)
            ->with(['chef', 'category', 'comments.user', 'likes'])
            ->first();

        if (!$recipe) {
            return response()->json([
                'success' => false,
                'message' => 'Recette non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $recipe
        ]);
    }

    /**
     * Mettre à jour une recette
     */
    public function update(Request $request, $recipeId)
    {
        $recipe = Recipe::where('recipeId', $recipeId)->first();

        if (!$recipe) {
            return response()->json([
                'success' => false,
                'message' => 'Recette non trouvée'
            ], 404);
        }

        // Vérifier que l'utilisateur est le propriétaire de la recette
        if ($recipe->chefId !== $request->user()->userId) {
            return response()->json([
                'success' => false,
                'message' => 'Non autorisé à modifier cette recette'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'ingredients' => 'sometimes|array',
            'steps' => 'sometimes|array',
            'categoryId' => 'sometimes|string|exists:categories,categoryId',
            'duration' => 'sometimes|string',
            'imageUrl' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $recipe->update($request->only([
            'title', 'description', 'ingredients', 'steps',
            'categoryId', 'duration', 'imageUrl'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Recette mise à jour avec succès',
            'data' => $recipe->load(['chef', 'category'])
        ]);
    }

    /**
     * Supprimer une recette
     */
    public function destroy(Request $request, $recipeId)
    {
        $recipe = Recipe::where('recipeId', $recipeId)->first();

        if (!$recipe) {
            return response()->json([
                'success' => false,
                'message' => 'Recette non trouvée'
            ], 404);
        }

        // Vérifier que l'utilisateur est le propriétaire de la recette
        if ($recipe->chefId !== $request->user()->userId) {
            return response()->json([
                'success' => false,
                'message' => 'Non autorisé à supprimer cette recette'
            ], 403);
        }

        $recipe->delete();

        return response()->json([
            'success' => true,
            'message' => 'Recette supprimée avec succès'
        ]);
    }

    /**
     * Recettes populaires
     */
    public function popular()
    {
        $recipes = Recipe::with(['chef', 'category'])
            ->orderBy('likesCount', 'desc')
            ->orderBy('favoritesCount', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $recipes
        ]);
    }

    /**
     * Recettes récentes
     */
    public function recent()
    {
        $recipes = Recipe::with(['chef', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $recipes
        ]);
    }
}

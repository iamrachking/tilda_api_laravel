<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    /**
     * Liste des commentaires d'une recette
     */
    public function index(Request $request, $recipeId)
    {
        $comments = Comment::where('recipeId', $recipeId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $comments
        ]);
    }

    /**
     * Créer un commentaire
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipeId' => 'required|string|exists:recipes,recipeId',
            'text' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        $comment = Comment::create([
            'commentId' => Str::uuid(),
            'userId' => $user->userId,
            'recipeId' => $request->recipeId,
            'text' => $request->text,
        ]);

        // Mettre à jour le compteur de commentaires
        Recipe::where('recipeId', $request->recipeId)
            ->increment('commentsCount');

        return response()->json([
            'success' => true,
            'message' => 'Commentaire ajouté',
            'data' => $comment->load('user')
        ], 201);
    }

    /**
     * Mettre à jour un commentaire
     */
    public function update(Request $request, $commentId)
    {
        $comment = Comment::where('commentId', $commentId)->first();

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Commentaire non trouvé'
            ], 404);
        }

        // Vérifier que l'utilisateur est le propriétaire du commentaire
        if ($comment->userId !== $request->user()->userId) {
            return response()->json([
                'success' => false,
                'message' => 'Non autorisé à modifier ce commentaire'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment->update(['text' => $request->text]);

        return response()->json([
            'success' => true,
            'message' => 'Commentaire mis à jour',
            'data' => $comment->load('user')
        ]);
    }

    /**
     * Supprimer un commentaire
     */
    public function destroy(Request $request, $commentId)
    {
        $comment = Comment::where('commentId', $commentId)->first();

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Commentaire non trouvé'
            ], 404);
        }

        // Vérifier que l'utilisateur est le propriétaire du commentaire
        if ($comment->userId !== $request->user()->userId) {
            return response()->json([
                'success' => false,
                'message' => 'Non autorisé à supprimer ce commentaire'
            ], 403);
        }

        $comment->delete();

        // Mettre à jour le compteur de commentaires
        Recipe::where('recipeId', $comment->recipeId)
            ->decrement('commentsCount');

        return response()->json([
            'success' => true,
            'message' => 'Commentaire supprimé'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Créer ou mettre à jour un utilisateur depuis Firebase
     */
    public function createOrUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'avatarUrl' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::updateOrCreate(
            ['userId' => $request->userId],
            [
                'name' => $request->name,
                'email' => $request->email,
                'avatarUrl' => $request->avatarUrl,
                'bio' => $request->bio,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur créé/mis à jour avec succès',
            'data' => $user
        ]);
    }

    /**
     * Récupérer le profil utilisateur
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Mettre à jour le profil utilisateur
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'bio' => 'sometimes|nullable|string',
            'avatarUrl' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $user->update($request->only(['name', 'bio', 'avatarUrl']));

        return response()->json([
            'success' => true,
            'message' => 'Profil mis à jour avec succès',
            'data' => $user
        ]);
    }

    /**
     * Récupérer les recettes de l'utilisateur
     */
    public function recipes(Request $request)
    {
        $user = $request->user();
        
        $recipes = $user->recipes()
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $recipes
        ]);
    }
}

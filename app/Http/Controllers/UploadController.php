<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Upload d'une image pour les catégories
     */
    public function uploadCategoryImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Générer un nom unique pour le fichier
        $fileName = 'category_' . Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
        
        // Stocker le fichier dans le dossier public/images/categories
        $path = $request->file('image')->storeAs('images/categories', $fileName, 'public');
        
        // Générer l'URL complète
        $url = asset('storage/' . $path);

        return response()->json([
            'success' => true,
            'url' => $url,
            'path' => $path,
            'fileName' => $fileName
        ]);
    }

    /**
     * Upload d'une image pour les recettes
     */
    public function uploadRecipeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $fileName = 'recipe_' . Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('images/recipes', $fileName, 'public');
        $url = asset('storage/' . $path);

        return response()->json([
            'success' => true,
            'url' => $url,
            'path' => $path,
            'fileName' => $fileName
        ]);
    }

    /**
     * Upload d'une image pour les avatars
     */
    public function uploadAvatarImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $fileName = 'avatar_' . Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('images/avatars', $fileName, 'public');
        $url = asset('storage/' . $path);

        return response()->json([
            'success' => true,
            'url' => $url,
            'path' => $path,
            'fileName' => $fileName
        ]);
    }

    /**
     * Supprimer une image
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->path;
        
        // Supprimer le fichier
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            
            return response()->json([
                'success' => true,
                'message' => 'Image supprimée avec succès'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image non trouvée'
        ], 404);
    }
}

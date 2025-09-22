<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Upload d'une image
     */
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:avatar,recipe,category',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $file = $request->file('image');
        $type = $request->type;
        
        // Générer un nom unique pour le fichier
        $fileName = $type . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        // Stocker le fichier dans le dossier public/images
        $path = $file->storeAs('images/' . $type, $fileName, 'public');
        
        // Générer l'URL complète
        $url = asset('storage/' . $path);

        return response()->json([
            'success' => true,
            'message' => 'Image uploadée avec succès',
            'data' => [
                'url' => $url,
                'path' => $path,
                'fileName' => $fileName
            ]
        ]);
    }

    /**
     * Supprimer une image
     */
    public function deleteImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

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

<?php

namespace App\Traits;

use App\Models\User;

trait HandlesUserFromHeaders
{
    /**
     * Récupère ou crée l'utilisateur depuis les en-têtes HTTP
     */
    protected function getUserFromHeaders($request)
    {
        $userId = $request->header('X-User-ID');
        
        if (!$userId) {
            return null;
        }

        return User::firstOrCreate(
            ['userId' => $userId],
            [
                'name' => $request->header('X-User-Name', 'Utilisateur'),
                'email' => $request->header('X-User-Email', ''),
                'avatarUrl' => $request->header('X-User-Avatar', null),
            ]
        );
    }

    /**
     * Vérifie si l'utilisateur est autorisé à effectuer l'action
     */
    protected function requireUser($request)
    {
        $userId = $request->header('X-User-ID');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID requis dans l\'en-tête X-User-ID'
            ], 401);
        }

        return null; // Pas d'erreur
    }
}

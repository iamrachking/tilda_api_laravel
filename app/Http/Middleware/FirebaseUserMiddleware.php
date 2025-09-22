<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class FirebaseUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->header('X-User-ID');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID requis dans l\'en-tête X-User-ID'
            ], 401);
        }

        // Crée ou récupère l’utilisateur
        $user = User::firstOrCreate(
            ['userId' => $userId],
            [
                'name' => $request->header('X-User-Name', 'Utilisateur'),
                'email' => $request->header('X-User-Email', ''),
                'avatarUrl' => $request->header('X-User-Avatar', null),
            ]
        );

        // Ajoute l’utilisateur dans la requête (dispo dans les contrôleurs)
        $request->merge(['authUser' => $user]);

        return $next($request);
    }
}

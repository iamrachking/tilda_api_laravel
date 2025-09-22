<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Gestion des erreurs pour les routes API
        if ($request->is('api/*')) {
            if ($e instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $e->errors()
                ], 422);
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ressource non trouvée'
                ], 404);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint non trouvé'
                ], 404);
            }

            // Erreur serveur générique
            return response()->json([
                'success' => false,
                'message' => 'Erreur interne du serveur',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur est survenue'
            ], 500);
        }

        return parent::render($request, $e);
    }
}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tilda Recipes Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card shadow-lg" style="max-width: 500px; border-radius: 20px;">
            <div class="card-body text-center p-5">
                <i class="fas fa-utensils text-primary mb-3" style="font-size: 4rem;"></i>
                
                <h1 class="h2 mb-3">Tilda Recipes Admin</h1>
                <p class="text-muted mb-4">
                    Interface d'administration pour votre application de recettes
                </p>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-tags me-2"></i>
                        Gérer les Catégories
                    </a>
                    
                    <a href="{{ url('/api') }}" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-code me-2"></i>
                        Documentation API
                    </a>
                </div>
                
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Interface d'administration pour l'API Tilda Recipes
                    </small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

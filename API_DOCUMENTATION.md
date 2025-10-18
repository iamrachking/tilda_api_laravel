# API Documentation - Tilda Recipes

## Configuration

### Base URL
```
http://localhost:8000/api
```

### Authentification
L'API utilise Firebase Auth via en-têtes HTTP. Incluez ces en-têtes pour les routes protégées :
```http
X-User-ID: firebase_user_123
X-User-Name: John Doe
X-User-Email: john@example.com
X-User-Avatar: https://example.com/avatar.jpg
```

## Endpoints

### 👤 Utilisateurs

#### POST /users/create
Créer ou mettre à jour un utilisateur depuis Firebase
```json
{
    "userId": "firebase_user_123",
    "name": "John Doe",
    "email": "john@example.com",
    "avatarUrl": "https://example.com/avatar.jpg",
    "bio": "Passionné de cuisine"
}
```

**Réponse :**
```json
{
    "success": true,
    "message": "Utilisateur créé/mis à jour avec succès",
    "data": {
        "id": 1,
        "userId": "firebase_user_123",
        "name": "John Doe",
        "email": "john@example.com",
        "avatarUrl": "https://example.com/avatar.jpg",
        "bio": "Passionné de cuisine",
        "created_at": "2024-01-01T10:00:00.000000Z",
        "updated_at": "2024-01-01T10:00:00.000000Z"
    }
}
```

#### GET /users/profile
Récupérer le profil utilisateur (nécessite authentification)

#### PUT /users/profile
Mettre à jour le profil utilisateur (nécessite authentification)
```json
{
    "name": "John Updated",
    "bio": "Nouvelle bio",
    "avatarUrl": "https://example.com/new-avatar.jpg"
}
```

#### GET /users/my-recipes
Récupérer les recettes de l'utilisateur (nécessite authentification)

### 📂 Catégories

#### GET /categories
Liste de toutes les catégories avec leurs recettes associées

**Réponse :**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "categoryId": "cat_uuid_123",
            "name": "Plats principaux",
            "imageUrl": "https://example.com/category.jpg",
            "created_at": "2024-01-01T09:00:00.000000Z",
            "updated_at": "2024-01-01T09:00:00.000000Z",
            "recipes": [
                {
                    "id": 1,
                    "recipeId": "recipe_uuid_123",
                    "title": "Pâtes Carbonara",
                    "imageUrl": "https://example.com/recipe.jpg",
                    "description": "Une délicieuse recette de pâtes",
                    "categoryId": "cat_uuid_123",
                    "chefId": "firebase_user_123",
                    "duration": "20 min",
                    "likesCount": 15,
                    "created_at": "2024-01-01T10:00:00.000000Z",
                    "updated_at": "2024-01-01T10:00:00.000000Z"
                }
            ]
        }
    ]
}
```

#### GET /categories/{categoryId}
Détails d'une catégorie avec toutes ses recettes associées

#### GET /categories/{categoryId}/recipes
Récupérer toutes les recettes d'une catégorie avec pagination

**Paramètres de requête :**
- `page` : numéro de page (défaut: 1)
- `per_page` : nombre d'éléments par page (défaut: 15)
- `search` : rechercher par titre dans les recettes de cette catégorie
- `sortBy` : trier par (created_at, title, likesCount, favoritesCount)
- `sortOrder` : ordre (asc, desc)

**Exemple :**
```
GET /categories/cat_uuid_123/recipes?search=pâtes&sortBy=likesCount&sortOrder=desc&page=1&per_page=10
```

**Réponse :**
```json
{
    "success": true,
    "data": {
        "category": {
            "id": 1,
            "categoryId": "cat_uuid_123",
            "name": "Plats principaux",
            "imageUrl": "https://example.com/category.jpg"
        },
        "recipes": {
            "current_page": 1,
            "data": [
                {
                    "id": 1,
                    "recipeId": "recipe_uuid_123",
                    "title": "Pâtes Carbonara",
                    "imageUrl": "https://example.com/recipe.jpg",
                    "description": "Une délicieuse recette de pâtes",
                    "categoryId": "cat_uuid_123",
                    "chefId": "firebase_user_123",
                    "duration": "20 min",
                    "likesCount": 15,
                    "created_at": "2024-01-01T10:00:00.000000Z",
                    "updated_at": "2024-01-01T10:00:00.000000Z",
                    "chef": {
                        "id": 1,
                        "userId": "firebase_user_123",
                        "name": "John Doe",
                        "email": "john@example.com",
                        "avatarUrl": "https://example.com/avatar.jpg"
                    }
                }
            ],
            "first_page_url": "http://localhost:8000/api/categories/cat_uuid_123/recipes?page=1",
            "from": 1,
            "last_page": 3,
            "last_page_url": "http://localhost:8000/api/categories/cat_uuid_123/recipes?page=3",
            "next_page_url": "http://localhost:8000/api/categories/cat_uuid_123/recipes?page=2",
            "path": "http://localhost:8000/api/categories/cat_uuid_123/recipes",
            "per_page": 15,
            "prev_page_url": null,
            "to": 15,
            "total": 45
        }
    }
}
```

#### POST /categories
Créer une catégorie
```json
{
    "name": "Desserts",
    "imageUrl": "https://example.com/category.jpg"
}
```

#### PUT /categories/{categoryId}
Modifier une catégorie

#### DELETE /categories/{categoryId}
Supprimer une catégorie

### 🍽️ Recettes

#### GET /recipes
Liste des recettes avec pagination et filtres

**Paramètres de requête :**
- `page` : numéro de page (défaut: 1)
- `per_page` : nombre d'éléments par page (défaut: 15)
- `categoryId` : filtrer par catégorie
- `search` : rechercher par titre
- `sortBy` : trier par (created_at, title, rating, likesCount)
- `sortOrder` : ordre (asc, desc)

**Exemple :**
```
GET /recipes?categoryId=cat_123&search=pâtes&sortBy=likesCount&sortOrder=desc
```

**Réponse :**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "recipeId": "recipe_uuid_123",
                "title": "Pâtes Carbonara",
                "imageUrl": "https://example.com/recipe.jpg",
                "description": "Une délicieuse recette de pâtes",
                "ingredients": [
                    {"name": "Pâtes", "quantity": "300g"},
                    {"name": "Lardons", "quantity": "150g"}
                ],
                "steps": [
                    "Faire cuire les pâtes",
                    "Cuire les lardons"
                ],
                "categoryId": "cat_uuid_123",
                "chefId": "firebase_user_123",
                "duration": "20 min",
                "likesCount": 15,
                "commentsCount": 3,
                "favoritesCount": 8,
                "rating": 4.50,
                "created_at": "2024-01-01T10:00:00.000000Z",
                "updated_at": "2024-01-01T10:00:00.000000Z",
                "chef": {
                    "id": 1,
                    "userId": "firebase_user_123",
                    "name": "John Doe",
                    "email": "john@example.com",
                    "avatarUrl": "https://example.com/avatar.jpg"
                },
                "category": {
                    "id": 1,
                    "categoryId": "cat_uuid_123",
                    "name": "Plats principaux",
                    "imageUrl": "https://example.com/category.jpg"
                }
            }
        ],
        "first_page_url": "http://localhost:8000/api/recipes?page=1",
        "from": 1,
        "last_page": 5,
        "last_page_url": "http://localhost:8000/api/recipes?page=5",
        "next_page_url": "http://localhost:8000/api/recipes?page=2",
        "path": "http://localhost:8000/api/recipes",
        "per_page": 15,
        "prev_page_url": null,
        "to": 15,
        "total": 75
    }
}
```

#### GET /recipes/popular
Recettes populaires (top 10)

#### GET /recipes/recent
Recettes récentes (top 10)

#### GET /recipes/{recipeId}
Détails d'une recette avec relations complètes

#### POST /recipes
Créer une recette (nécessite authentification)
```json
{
    "title": "Pâtes Carbonara",
    "description": "Une délicieuse recette de pâtes",
    "ingredients": [
        {"name": "Pâtes", "quantity": "300g"},
        {"name": "Lardons", "quantity": "150g"}
    ],
    "steps": [
        "Faire cuire les pâtes",
        "Cuire les lardons"
    ],
    "categoryId": "cat_uuid_123",
    "duration": "20 min",
    "imageUrl": "https://example.com/recipe.jpg"
}
```

#### PUT /recipes/{recipeId}
Modifier une recette (nécessite authentification, propriétaire uniquement)

#### DELETE /recipes/{recipeId}
Supprimer une recette (nécessite authentification, propriétaire uniquement)

### ❤️ Favoris

#### GET /favorites
Liste des favoris de l'utilisateur (nécessite authentification)

#### POST /favorites
Ajouter une recette aux favoris (nécessite authentification)
```json
{
    "recipeId": "recipe_uuid_123"
}
```

#### DELETE /favorites/{recipeId}
Supprimer des favoris (nécessite authentification)

#### GET /favorites/check/{recipeId}
Vérifier si une recette est en favori (nécessite authentification)
```json
{
    "success": true,
    "data": {
        "isFavorite": true
    }
}
```

### 👍 Likes

#### GET /likes
Liste des recettes likées par l'utilisateur (nécessite authentification)

#### POST /likes
Liker une recette (nécessite authentification)
```json
{
    "recipeId": "recipe_uuid_123"
}
```

#### DELETE /likes/{recipeId}
Unliker une recette (nécessite authentification)

#### GET /likes/check/{recipeId}
Vérifier si une recette est likée (nécessite authentification)

### 💬 Commentaires

#### GET /recipes/{recipeId}/comments
Liste des commentaires d'une recette

#### POST /comments
Créer un commentaire (nécessite authentification)
```json
{
    "recipeId": "recipe_uuid_123",
    "text": "Excellente recette !"
}
```

#### PUT /comments/{commentId}
Modifier un commentaire (nécessite authentification, propriétaire uniquement)

#### DELETE /comments/{commentId}
Supprimer un commentaire (nécessite authentification, propriétaire uniquement)

### 📸 Upload d'images

#### POST /upload/image
Uploader une image (nécessite authentification)

**FormData :**
- `image` : fichier image (jpeg, png, jpg, gif, max 2MB)
- `type` : type d'image (avatar, recipe, category)

**Réponse :**
```json
{
    "success": true,
    "message": "Image uploadée avec succès",
    "data": {
        "url": "http://localhost:8000/storage/images/recipe/recipe_uuid_123.jpg",
        "path": "images/recipe/recipe_uuid_123.jpg",
        "fileName": "recipe_uuid_123.jpg"
    }
}
```

#### DELETE /upload/image
Supprimer une image (nécessite authentification)
```json
{
    "path": "images/recipe/filename.jpg"
}
```

## Réponses API

### Format de réponse standard
```json
{
    "success": true,
    "message": "Message de succès",
    "data": {
        // Données de la réponse
    }
}
```

### Format d'erreur
```json
{
    "success": false,
    "message": "Message d'erreur",
    "errors": {
        "field": ["Message d'erreur spécifique"]
    }
}
```

## Codes de statut HTTP

- `200` : Succès
- `201` : Créé avec succès
- `400` : Requête invalide
- `401` : Non authentifié (headers Firebase manquants)
- `403` : Non autorisé (propriétaire uniquement)
- `404` : Non trouvé
- `409` : Conflit (doublon)
- `422` : Erreur de validation
- `500` : Erreur serveur

## Structure des données

### Modèle Recipe
```json
{
    "id": 1,
    "recipeId": "recipe_uuid_123",
    "title": "Pâtes Carbonara",
    "imageUrl": "https://example.com/recipe.jpg",
    "description": "Description de la recette",
    "ingredients": [
        {"name": "Pâtes", "quantity": "300g"},
        {"name": "Lardons", "quantity": "150g"}
    ],
    "steps": [
        "Étape 1",
        "Étape 2"
    ],
    "categoryId": "cat_uuid_123",
    "chefId": "firebase_user_123",
    "duration": "20 min",
    "likesCount": 15,
    "commentsCount": 3,
    "favoritesCount": 8,
    "rating": 4.50,
    "created_at": "2024-01-01T10:00:00.000000Z",
    "updated_at": "2024-01-01T10:00:00.000000Z",
    "chef": {
        // Objet User complet
    },
    "category": {
        // Objet Category complet
    }
}
```

### Modèle User
```json
{
    "id": 1,
    "userId": "firebase_user_123",
    "name": "John Doe",
    "email": "john@example.com",
    "avatarUrl": "https://example.com/avatar.jpg",
    "bio": "Passionné de cuisine",
    "created_at": "2024-01-01T09:00:00.000000Z",
    "updated_at": "2024-01-01T09:00:00.000000Z"
}
```

### Modèle Category
```json
{
    "id": 1,
    "categoryId": "cat_uuid_123",
    "name": "Plats principaux",
    "imageUrl": "https://example.com/category.jpg",
    "created_at": "2024-01-01T09:00:00.000000Z",
    "updated_at": "2024-01-01T09:00:00.000000Z",
    "recipes": [
        {
            "id": 1,
            "recipeId": "recipe_uuid_123",
            "title": "Pâtes Carbonara",
            "imageUrl": "https://example.com/recipe.jpg",
            "description": "Description de la recette",
            "categoryId": "cat_uuid_123",
            "chefId": "firebase_user_123",
            "duration": "20 min",
            "likesCount": 15,
            "created_at": "2024-01-01T10:00:00.000000Z",
            "updated_at": "2024-01-01T10:00:00.000000Z"
        }
    ]
}
```

## Exemples d'utilisation

### Créer une recette
```bash
curl -X POST http://localhost:8000/api/recipes \
  -H "Content-Type: application/json" \
  -H "X-User-ID: firebase_user_123" \
  -H "X-User-Name: John Doe" \
  -H "X-User-Email: john@example.com" \
  -d '{
    "title": "Pâtes Carbonara",
    "description": "Une délicieuse recette",
    "ingredients": [{"name": "Pâtes", "quantity": "300g"}],
    "steps": ["Faire cuire les pâtes"],
    "categoryId": "cat_uuid_123",
    "duration": "20 min"
  }'
```

### Récupérer les recettes
```bash
curl -X GET "http://localhost:8000/api/recipes?page=1&per_page=10&search=pâtes" \
  -H "X-User-ID: firebase_user_123"
```

### Récupérer les catégories avec leurs recettes
```bash
curl -X GET "http://localhost:8000/api/categories"
```

### Récupérer toutes les recettes d'une catégorie
```bash
curl -X GET "http://localhost:8000/api/categories/cat_uuid_123/recipes?search=pâtes&sortBy=likesCount&sortOrder=desc"
```

---

**Documentation mise à jour pour Tilda Recipes API v1.0**
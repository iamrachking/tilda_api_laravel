# 🍳 Tilda Recipes API

API backend pour l'application mobile de recettes de cuisine développée avec Flutter.

## ✨ Fonctionnalités

- **Authentification Firebase** : Intégration transparente avec Firebase Auth
- **Gestion des recettes** : CRUD complet avec recherche et filtres
- **Catégories** : Organisation des recettes par catégories
- **Système social** : Likes, favoris et commentaires
- **Upload d'images** : Gestion des images de profil, recettes et catégories
- **API RESTful** : Endpoints structurés avec pagination

## 🛠️ Technologies

- **Laravel 12** (PHP 8.2+)
- **SQLite/MySQL** (Base de données)
- **Firebase Auth** (Authentification)
- **Laravel Storage** (Fichiers)

## ⚡ Installation

### Installation Rapide

#### Windows
```powershell
.\setup.ps1
```

#### Linux/Mac
```bash
chmod +x setup.sh
./setup.sh
```

### Installation Manuelle

1. **Cloner et installer**
```bash
git clone <repository-url>
cd tilda_api_laravel
composer install
npm install
```

2. **Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Base de données**
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

4. **Démarrer**
```bash
php artisan serve
```

API disponible sur `http://localhost:8000/api`

## 📚 Documentation API

- **[Documentation complète](API_DOCUMENTATION.md)** - Tous les endpoints
- **[Guide Firebase](FIREBASE_AUTH_GUIDE.md)** - Intégration Flutter

### Endpoints Principaux

```
# Utilisateurs
POST   /api/users/create
GET    /api/users/profile
PUT    /api/users/profile

# Catégories
GET    /api/categories
POST   /api/categories
PUT    /api/categories/{id}
DELETE /api/categories/{id}

# Recettes
GET    /api/recipes
GET    /api/recipes/popular
GET    /api/recipes/recent
POST   /api/recipes
PUT    /api/recipes/{id}
DELETE /api/recipes/{id}

# Social
GET    /api/favorites
POST   /api/favorites
GET    /api/likes
POST   /api/likes
GET    /api/recipes/{id}/comments
POST   /api/comments

# Upload
POST   /api/upload/image
DELETE /api/upload/image
```

## 🔑 Authentification

L'API utilise Firebase Auth via en-têtes HTTP :

```http
X-User-ID: firebase_user_123
X-User-Name: John Doe
X-User-Email: john@example.com
X-User-Avatar: https://example.com/avatar.jpg
```

## 🗄️ Base de Données

### Tables
- `users` - Utilisateurs (Firebase)
- `categories` - Catégories de recettes
- `recipes` - Recettes de cuisine
- `favorites` - Favoris utilisateurs
- `likes` - Likes utilisateurs
- `comments` - Commentaires recettes

### Relations
- User → hasMany → Recipes, Favorites, Likes, Comments
- Recipe → belongsTo → User (chef), Category
- Category → hasMany → Recipes

<!-- ## 📱 Intégration Flutter

### Modèle Recipe exemple
```dart
class Recipe {
  final String recipeId;
  final String title;
  final String? imageUrl;
  final String description;
  final List<Map<String, dynamic>> ingredients;
  final List<String> steps;
  final String categoryId;  // ID pour l'envoi
  final String chefId;      // ID pour l'envoi
  final User? chef;         // Objet complet pour l'affichage
  final Category? category; // Objet complet pour l'affichage
  // ... autres propriétés
}
```

### Flux d'authentification
1. Connexion Firebase (une fois)
2. Stockage local des infos utilisateur
3. Envoi des headers à chaque requête API
4. Création automatique de l'utilisateur en base

<!-- ## 🧪 Tests

```bash
php artisan test
```

## 🚀 Déploiement

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
``` -->

## 📄 Licence

MIT License

---

**Développé avec ❤️ pour Tilda Recipes**
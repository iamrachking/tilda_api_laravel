# Tilda Recipes API

Backend Laravel pour l’app mobile de recettes (Flutter). Authentification Firebase, CRUD recettes, catégories, favoris, likes, commentaires et upload d’images.

## Prérequis

- PHP 8.2+
- Composer
- SQLite ou MySQL
- Node.js (pour les assets si besoin)

## Installation

**Cloner et dépendances :**
```bash
git clone <repository-url>
cd tilda_api_laravel
composer install
```

**Environnement :**
```bash
cp .env.example .env
php artisan key:generate
```

**Base de données :**
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

**Lancer le serveur :**
```bash
php artisan serve
```

L’API est disponible sur `http://localhost:8000/api`.

### Scripts d’installation

- Windows : `.\setup.ps1`
- Linux/Mac : `chmod +x setup.sh` puis `./setup.sh`

## Authentification

L’API s’appuie sur Firebase Auth. Les infos utilisateur sont passées en en-têtes :

```
X-User-ID: <firebase_uid>
X-User-Name: <nom>
X-User-Email: <email>
X-User-Avatar: <url_avatar>
```

## Endpoints

| Méthode | Route | Description |
|--------|--------|-------------|
| POST | /api/users/create | Créer un utilisateur |
| GET | /api/users/profile | Profil utilisateur |
| PUT | /api/users/profile | Modifier le profil |
| GET | /api/categories | Liste des catégories |
| POST | /api/categories | Créer une catégorie |
| PUT | /api/categories/{id} | Modifier une catégorie |
| DELETE | /api/categories/{id} | Supprimer une catégorie |
| GET | /api/recipes | Liste des recettes |
| GET | /api/recipes/popular | Recettes populaires |
| GET | /api/recipes/recent | Recettes récentes |
| POST | /api/recipes | Créer une recette |
| PUT | /api/recipes/{id} | Modifier une recette |
| DELETE | /api/recipes/{id} | Supprimer une recette |
| GET | /api/favorites | Favoris |
| POST | /api/favorites | Ajouter aux favoris |
| GET | /api/likes | Likes |
| POST | /api/likes | Liker |
| GET | /api/recipes/{id}/comments | Commentaires d’une recette |
| POST | /api/comments | Ajouter un commentaire |
| POST | /api/upload/image | Upload image |
| DELETE | /api/upload/image | Supprimer image |

## Documentation

- [API détaillée](API_DOCUMENTATION.md)
- [Firebase + Flutter](FIREBASE_AUTH_GUIDE.md)

## Base de données

Tables principales : `users`, `categories`, `recipes`, `favorites`, `likes`, `comments`. Un utilisateur a des recettes, favoris, likes et commentaires ; une recette appartient à un utilisateur (chef) et à une catégorie.

## Licence

MIT

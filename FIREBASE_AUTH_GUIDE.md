# 🔥 Guide Firebase Auth - API Tilda Recipes

## Vue d'ensemble

L'API Laravel fonctionne **SANS authentification côté serveur**. L'authentification est entièrement gérée par Firebase Auth côté Flutter. L'API Laravel fait simplement confiance aux informations utilisateur envoyées par Flutter via les en-têtes HTTP.

## 🔧 Configuration côté Flutter

### En-têtes requis pour les requêtes authentifiées

```dart
// Après connexion Firebase Auth (pas besoin de token côté serveur)
String userId = FirebaseAuth.instance.currentUser!.uid;
String userName = FirebaseAuth.instance.currentUser!.displayName ?? '';
String userEmail = FirebaseAuth.instance.currentUser!.email ?? '';

// Configuration des en-têtes pour vos requêtes HTTP
Map<String, String> headers = {
  'X-User-ID': userId,
  'X-User-Name': userName,
  'X-User-Email': userEmail,
  'X-User-Avatar': FirebaseAuth.instance.currentUser!.photoURL ?? '',
  'Content-Type': 'application/json',
};
```

### Exemple d'utilisation avec http package

```dart
import 'package:http/http.dart' as http;

Future<void> createRecipe() async {
  // Récupérer les informations Firebase
  User? user = FirebaseAuth.instance.currentUser;
  
  // Préparer les en-têtes (pas besoin de token)
  Map<String, String> headers = {
    'X-User-ID': user!.uid,
    'X-User-Name': user.displayName ?? '',
    'X-User-Email': user.email ?? '',
    'X-User-Avatar': user.photoURL ?? '',
    'Content-Type': 'application/json',
  };

  // Créer la recette
  var response = await http.post(
    Uri.parse('http://localhost:8000/api/recipes'),
    headers: headers,
    body: jsonEncode({
      'title': 'Ma recette',
      'description': 'Description de la recette',
      'ingredients': [
        {'name': 'Tomates', 'quantity': '3'},
        {'name': 'Oignons', 'quantity': '1'}
      ],
      'steps': [
        'Éplucher les tomates',
        'Couper les oignons'
      ],
      'categoryId': 'cat_001',
      'duration': '30 min',
    }),
  );
}
```

## 🛡️ Gestion des Utilisateurs

L'API fonctionne **SANS middleware d'authentification**. Chaque contrôleur gère directement les utilisateurs :

1. **Récupération du userId** : Extrait le userId depuis l'en-tête `X-User-ID`
2. **Création automatique** : Crée l'utilisateur dans la base de données s'il n'existe pas
3. **Vérification de propriété** : Vérifie que l'utilisateur peut modifier/supprimer ses propres ressources
4. **Pas de vérification de token** : L'API fait entièrement confiance à Flutter pour l'authentification

## 📋 Endpoints API

### Toutes les routes API (toutes publiques)

```http
# Gestion des utilisateurs
POST /api/users/create
GET /api/users/profile
PUT /api/users/profile
GET /api/users/my-recipes

# Gestion des catégories
GET /api/categories
GET /api/categories/{categoryId}
POST /api/categories
PUT /api/categories/{categoryId}
DELETE /api/categories/{categoryId}

# Gestion des recettes
GET /api/recipes
GET /api/recipes/popular
GET /api/recipes/recent
GET /api/recipes/{recipeId}
POST /api/recipes
PUT /api/recipes/{recipeId}
DELETE /api/recipes/{recipeId}

# Favoris
GET /api/favorites
POST /api/favorites
DELETE /api/favorites/{recipeId}
GET /api/favorites/check/{recipeId}

# Likes
GET /api/likes
POST /api/likes
DELETE /api/likes/{recipeId}
GET /api/likes/check/{recipeId}

# Commentaires
GET /api/recipes/{recipeId}/comments
POST /api/comments
PUT /api/comments/{commentId}
DELETE /api/comments/{commentId}

# Upload d'images
POST /api/upload/image
DELETE /api/upload/image
```

**Note :** Toutes les routes sont publiques, mais certaines nécessitent l'en-tête `X-User-ID` pour identifier l'utilisateur.

## 🔄 Flux d'authentification

### 1. Connexion utilisateur (côté Flutter)
```dart
// Connexion avec Firebase Auth
await FirebaseAuth.instance.signInWithEmailAndPassword(
  email: email,
  password: password,
);
```

### 2. Création/synchronisation utilisateur (côté API)
```dart
// Appeler l'endpoint pour créer/mettre à jour l'utilisateur
User? user = FirebaseAuth.instance.currentUser;
String? token = await user?.getIdToken();

var response = await http.post(
  Uri.parse('http://localhost:8000/api/users/create'),
  headers: {
    'Authorization': 'Bearer $token',
    'Content-Type': 'application/json',
  },
  body: jsonEncode({
    'userId': user!.uid,
    'name': user.displayName ?? '',
    'email': user.email ?? '',
    'avatarUrl': user.photoURL,
    'bio': null,
  }),
);
```

### 3. Utilisation des endpoints protégés
```dart
// Toutes les requêtes suivantes incluent les en-têtes Firebase
String? token = await FirebaseAuth.instance.currentUser?.getIdToken();
// ... utiliser les en-têtes dans toutes les requêtes authentifiées
```

## 🚨 Gestion des erreurs

### Erreurs d'authentification

```json
// User ID manquant
{
  "success": false,
  "message": "User ID requis dans l'en-tête X-User-ID"
}
```

### Codes de statut HTTP

- `200` : Succès
- `201` : Créé avec succès
- `401` : Non authentifié (token ou user ID manquant)
- `403` : Non autorisé (utilisateur ne peut pas modifier cette ressource)
- `404` : Ressource non trouvée
- `422` : Erreur de validation

## 🔧 Configuration côté serveur

### Variables d'environnement

```env
# Aucune configuration Firebase nécessaire côté serveur
# L'authentification est entièrement gérée côté client
APP_NAME=TildaRecipesAPI
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### Middleware personnalisé

Le middleware `FirebaseAuth` est automatiquement enregistré et peut être utilisé sur toutes les routes protégées.

## 📱 Exemple complet Flutter

```dart
class ApiService {
  static const String baseUrl = 'http://localhost:8000/api';
  
  static Future<Map<String, String>> _getAuthHeaders() async {
    User? user = FirebaseAuth.instance.currentUser;
    
    return {
      'X-User-ID': user!.uid,
      'X-User-Name': user.displayName ?? '',
      'X-User-Email': user.email ?? '',
      'X-User-Avatar': user.photoURL ?? '',
      'Content-Type': 'application/json',
    };
  }
  
  static Future<List<Recipe>> getRecipes() async {
    final response = await http.get(
      Uri.parse('$baseUrl/recipes'),
      headers: await _getAuthHeaders(),
    );
    
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return (data['data']['data'] as List)
          .map((json) => Recipe.fromJson(json))
          .toList();
    }
    throw Exception('Failed to load recipes');
  }
  
  static Future<void> createRecipe(Recipe recipe) async {
    final response = await http.post(
      Uri.parse('$baseUrl/recipes'),
      headers: await _getAuthHeaders(),
      body: jsonEncode(recipe.toJson()),
    );
    
    if (response.statusCode != 201) {
      throw Exception('Failed to create recipe');
    }
  }
}
```

## ✅ Avantages de cette approche

1. **Simplicité maximale** : Aucune gestion d'authentification côté serveur
2. **Sécurité** : Firebase gère entièrement la sécurité et l'authentification
3. **Flexibilité** : Facile à intégrer avec Flutter
4. **Performance** : Aucune validation de token côté serveur
5. **Compatibilité** : Compatible avec votre structure Firebase existante
6. **Confiance** : L'API fait confiance aux informations envoyées par Flutter

Cette approche vous permet d'utiliser Firebase Auth dans Flutter pour toute l'authentification, et l'API Laravel se contente de stocker et gérer les données de recettes !

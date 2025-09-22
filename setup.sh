#!/bin/bash

echo "🚀 Installation de l'API Tilda Recipes..."

# Vérifier si composer est installé
if ! command -v composer &> /dev/null; then
    echo "❌ Composer n'est pas installé. Veuillez l'installer d'abord."
    exit 1
fi

# Vérifier si PHP est installé
if ! command -v php &> /dev/null; then
    echo "❌ PHP n'est pas installé. Veuillez l'installer d'abord."
    exit 1
fi

echo "📦 Installation des dépendances..."
composer install

echo "🔑 Génération de la clé d'application..."
php artisan key:generate

echo "🗄️ Configuration de la base de données..."
echo "Veuillez configurer votre base de données dans le fichier .env"

echo "📁 Création du lien de stockage..."
php artisan storage:link

echo "🏗️ Exécution des migrations..."
php artisan migrate

echo "🌱 Seeding des données initiales..."
php artisan db:seed

echo "✅ Installation terminée !"
echo ""
echo "Pour démarrer le serveur de développement :"
echo "php artisan serve"
echo ""
echo "L'API sera disponible sur : http://localhost:8000/api"
echo "Documentation disponible dans : API_DOCUMENTATION.md"

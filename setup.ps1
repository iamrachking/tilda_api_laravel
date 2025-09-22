# Script d'installation pour Windows PowerShell
Write-Host "🚀 Installation de l'API Tilda Recipes..." -ForegroundColor Green

# Vérifier si composer est installé
try {
    composer --version | Out-Null
    Write-Host "✅ Composer trouvé" -ForegroundColor Green
} catch {
    Write-Host "❌ Composer n'est pas installé. Veuillez l'installer d'abord." -ForegroundColor Red
    exit 1
}

# Vérifier si PHP est installé
try {
    php --version | Out-Null
    Write-Host "✅ PHP trouvé" -ForegroundColor Green
} catch {
    Write-Host "❌ PHP n'est pas installé. Veuillez l'installer d'abord." -ForegroundColor Red
    exit 1
}

Write-Host "📦 Installation des dépendances..." -ForegroundColor Yellow
composer install

Write-Host "🔑 Génération de la clé d'application..." -ForegroundColor Yellow
php artisan key:generate

Write-Host "🗄️ Configuration de la base de données..." -ForegroundColor Yellow
Write-Host "Veuillez configurer votre base de données dans le fichier .env" -ForegroundColor Cyan

Write-Host "📁 Création du lien de stockage..." -ForegroundColor Yellow
php artisan storage:link

Write-Host "🏗️ Exécution des migrations..." -ForegroundColor Yellow
php artisan migrate

Write-Host "🌱 Seeding des données initiales..." -ForegroundColor Yellow
php artisan db:seed

Write-Host "✅ Installation terminée !" -ForegroundColor Green
Write-Host ""
Write-Host "Pour démarrer le serveur de développement :" -ForegroundColor Cyan
Write-Host "php artisan serve" -ForegroundColor White
Write-Host ""
Write-Host "L'API sera disponible sur : http://localhost:8000/api" -ForegroundColor Cyan
Write-Host "Documentation disponible dans : API_DOCUMENTATION.md" -ForegroundColor Cyan

<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $chefs = User::all();
        
        $recipes = [
            // Entrées
            [
                'recipeId' => 'recipe_001',
                'title' => 'Salade César Classique',
                'imageUrl' => null,
                'description' => 'Une salade César traditionnelle avec croûtons, parmesan et sauce crémeuse.',
                'ingredients' => [
                    '1 cœur de laitue romaine',
                    '50g de parmesan râpé',
                    '2 tranches de pain de mie',
                    '2 gousses d\'ail',
                    '1 c. à soupe de moutarde de Dijon',
                    '2 c. à soupe de jus de citron',
                    '4 filets d\'anchois',
                    '1 œuf',
                    'Huile d\'olive',
                    'Sel et poivre'
                ],
                'steps' => [
                    'Préparer les croûtons : couper le pain en dés et les faire revenir dans l\'huile d\'olive avec l\'ail.',
                    'Préparer la sauce : mélanger la moutarde, le jus de citron, les anchois écrasés et l\'œuf.',
                    'Laver et couper la laitue en morceaux.',
                    'Mélanger la laitue avec la sauce et les croûtons.',
                    'Saupoudrer de parmesan et servir immédiatement.'
                ],
                'categoryId' => 'cat_001',
                'chefId' => 'user_001',
                'duration' => 20,
                'likesCount' => 45,
                'commentsCount' => 12,
                'favoritesCount' => 23,
                'rating' => 4.5
            ],
            [
                'recipeId' => 'recipe_002',
                'title' => 'Velouté de Potiron',
                'imageUrl' => null,
                'description' => 'Un velouté onctueux de potiron parfait pour l\'automne.',
                'ingredients' => [
                    '800g de potiron',
                    '1 oignon',
                    '2 gousses d\'ail',
                    '50cl de bouillon de légumes',
                    '20cl de crème fraîche',
                    '2 c. à soupe d\'huile d\'olive',
                    'Noix de muscade',
                    'Sel et poivre',
                    'Graines de courge (pour la décoration)'
                ],
                'steps' => [
                    'Éplucher et couper le potiron en cubes.',
                    'Émincer l\'oignon et l\'ail.',
                    'Faire revenir l\'oignon dans l\'huile d\'olive.',
                    'Ajouter le potiron et l\'ail, faire revenir 5 minutes.',
                    'Mouiller avec le bouillon et laisser cuire 25 minutes.',
                    'Mixer le tout et ajouter la crème fraîche.',
                    'Assaisonner avec sel, poivre et noix de muscade.',
                    'Servir chaud avec des graines de courge.'
                ],
                'categoryId' => 'cat_001',
                'chefId' => 'user_002',
                'duration' => 45,
                'likesCount' => 38,
                'commentsCount' => 8,
                'favoritesCount' => 19,
                'rating' => 4.2
            ],
            
            // Plats principaux
            [
                'recipeId' => 'recipe_003',
                'title' => 'Bœuf Bourguignon',
                'imageUrl' => null,
                'description' => 'Le classique français mijoté au vin rouge avec légumes.',
                'ingredients' => [
                    '1kg de bœuf à braiser',
                    '50cl de vin rouge',
                    '200g de lardons',
                    '200g de champignons',
                    '200g de petits oignons',
                    '2 carottes',
                    '2 gousses d\'ail',
                    '2 c. à soupe de farine',
                    'Bouquet garni',
                    'Sel et poivre'
                ],
                'steps' => [
                    'Couper la viande en cubes et la faire revenir.',
                    'Ajouter les lardons et les légumes.',
                    'Saupoudrer de farine et mouiller avec le vin.',
                    'Ajouter le bouquet garni et assaisonner.',
                    'Laisser mijoter 3 heures à feu doux.',
                    'Servir avec des pommes de terre vapeur.'
                ],
                'categoryId' => 'cat_002',
                'chefId' => 'user_003',
                'duration' => 200,
                'likesCount' => 67,
                'commentsCount' => 15,
                'favoritesCount' => 34,
                'rating' => 4.8
            ],
            [
                'recipeId' => 'recipe_004',
                'title' => 'Saumon en Papillote',
                'imageUrl' => null,
                'description' => 'Filet de saumon cuit en papillote avec légumes et herbes.',
                'ingredients' => [
                    '4 filets de saumon',
                    '2 courgettes',
                    '2 tomates',
                    '1 citron',
                    'Herbes de Provence',
                    'Huile d\'olive',
                    'Sel et poivre',
                    'Papier sulfurisé'
                ],
                'steps' => [
                    'Préchauffer le four à 180°C.',
                    'Couper les légumes en rondelles fines.',
                    'Déposer le saumon sur le papier sulfurisé.',
                    'Ajouter les légumes et les herbes.',
                    'Arroser d\'huile d\'olive et de jus de citron.',
                    'Fermer la papillote et cuire 20 minutes.',
                    'Servir immédiatement.'
                ],
                'categoryId' => 'cat_002',
                'chefId' => 'user_004',
                'duration' => 35,
                'likesCount' => 52,
                'commentsCount' => 11,
                'favoritesCount' => 28,
                'rating' => 4.6
            ],
            
            // Desserts
            [
                'recipeId' => 'recipe_005',
                'title' => 'Tarte Tatin',
                'imageUrl' => null,
                'description' => 'Tarte aux pommes caramélisées renversée, spécialité française.',
                'ingredients' => [
                    '1kg de pommes',
                    '200g de sucre',
                    '100g de beurre',
                    '1 pâte brisée',
                    '1 c. à café de cannelle',
                    'Jus de citron'
                ],
                'steps' => [
                    'Éplucher et couper les pommes en quartiers.',
                    'Faire caraméliser le sucre dans une poêle.',
                    'Ajouter le beurre et les pommes.',
                    'Laisser cuire 10 minutes en remuant.',
                    'Disposer dans un moule et recouvrir de pâte.',
                    'Cuire 30 minutes à 200°C.',
                    'Retourner sur un plat de service.'
                ],
                'categoryId' => 'cat_003',
                'chefId' => 'user_001',
                'duration' => 60,
                'likesCount' => 73,
                'commentsCount' => 18,
                'favoritesCount' => 41,
                'rating' => 4.7
            ],
            [
                'recipeId' => 'recipe_006',
                'title' => 'Mousse au Chocolat',
                'imageUrl' => null,
                'description' => 'Mousse au chocolat noir légère et aérienne.',
                'ingredients' => [
                    '200g de chocolat noir',
                    '4 œufs',
                    '50g de sucre',
                    '1 pincée de sel',
                    'Chantilly (pour servir)'
                ],
                'steps' => [
                    'Faire fondre le chocolat au bain-marie.',
                    'Séparer les blancs des jaunes d\'œufs.',
                    'Mélanger les jaunes avec le sucre.',
                    'Incorporer le chocolat fondu.',
                    'Monter les blancs en neige ferme.',
                    'Incorporer délicatement les blancs au mélange chocolat.',
                    'Répartir dans des verrines et réfrigérer 2h.',
                    'Servir avec de la chantilly.'
                ],
                'categoryId' => 'cat_003',
                'chefId' => 'user_002',
                'duration' => 30,
                'likesCount' => 89,
                'commentsCount' => 22,
                'favoritesCount' => 56,
                'rating' => 4.9
            ],
            
            // Boissons
            [
                'recipeId' => 'recipe_007',
                'title' => 'Smoothie Vert Détox',
                'imageUrl' => null,
                'description' => 'Smoothie aux épinards, pomme et gingembre pour une cure détox.',
                'ingredients' => [
                    '2 poignées d\'épinards frais',
                    '1 pomme verte',
                    '1 banane',
                    '1 morceau de gingembre',
                    '1 c. à soupe de miel',
                    '20cl d\'eau de coco',
                    'Glaçons'
                ],
                'steps' => [
                    'Laver les épinards et les équeuter.',
                    'Éplucher et couper la pomme en morceaux.',
                    'Peler le gingembre et le râper finement.',
                    'Mettre tous les ingrédients dans un blender.',
                    'Mixer jusqu\'à obtenir une texture lisse.',
                    'Ajouter des glaçons si nécessaire.',
                    'Servir immédiatement bien frais.'
                ],
                'categoryId' => 'cat_004',
                'chefId' => 'user_003',
                'duration' => 10,
                'likesCount' => 34,
                'commentsCount' => 7,
                'favoritesCount' => 16,
                'rating' => 4.1
            ],
            [
                'recipeId' => 'recipe_008',
                'title' => 'Thé Glacé Maison',
                'imageUrl' => null,
                'description' => 'Thé glacé parfumé aux fruits rouges et menthe.',
                'ingredients' => [
                    '4 sachets de thé noir',
                    '1L d\'eau',
                    '100g de fruits rouges',
                    'Quelques feuilles de menthe',
                    '2 c. à soupe de sucre',
                    'Glaçons',
                    'Citron (pour servir)'
                ],
                'steps' => [
                    'Faire infuser le thé dans l\'eau chaude 5 minutes.',
                    'Retirer les sachets et laisser refroidir.',
                    'Mixer les fruits rouges avec le sucre.',
                    'Mélanger le thé refroidi avec le coulis de fruits.',
                    'Ajouter les feuilles de menthe.',
                    'Réfrigérer 2 heures.',
                    'Servir avec des glaçons et une rondelle de citron.'
                ],
                'categoryId' => 'cat_004',
                'chefId' => 'user_004',
                'duration' => 15,
                'likesCount' => 28,
                'commentsCount' => 5,
                'favoritesCount' => 12,
                'rating' => 3.9
            ],
            
            // Apéritifs
            [
                'recipeId' => 'recipe_009',
                'title' => 'Bruschetta aux Tomates',
                'imageUrl' => null,
                'description' => 'Tranches de pain grillé aux tomates fraîches et basilic.',
                'ingredients' => [
                    '1 baguette de pain',
                    '4 tomates bien mûres',
                    '2 gousses d\'ail',
                    'Basilic frais',
                    'Huile d\'olive extra vierge',
                    'Sel et poivre',
                    'Vinaigre balsamique'
                ],
                'steps' => [
                    'Couper la baguette en tranches épaisses.',
                    'Griller les tranches des deux côtés.',
                    'Frotter avec l\'ail cru.',
                    'Couper les tomates en petits dés.',
                    'Mélanger avec le basilic ciselé et l\'huile d\'olive.',
                    'Déposer sur les tranches de pain.',
                    'Arroser d\'un filet de vinaigre balsamique.',
                    'Servir immédiatement.'
                ],
                'categoryId' => 'cat_005',
                'chefId' => 'user_001',
                'duration' => 20,
                'likesCount' => 41,
                'commentsCount' => 9,
                'favoritesCount' => 21,
                'rating' => 4.3
            ],
            [
                'recipeId' => 'recipe_010',
                'title' => 'Tapenade d\'Olives',
                'imageUrl' => null,
                'description' => 'Purée d\'olives noires aux câpres et anchois.',
                'ingredients' => [
                    '200g d\'olives noires dénoyautées',
                    '2 c. à soupe de câpres',
                    '4 filets d\'anchois',
                    '2 gousses d\'ail',
                    'Huile d\'olive',
                    'Jus de citron',
                    'Thym',
                    'Pain grillé (pour servir)'
                ],
                'steps' => [
                    'Égoutter les olives et les câpres.',
                    'Peler et dégermer l\'ail.',
                    'Mettre tous les ingrédients dans un mixer.',
                    'Mixer en ajoutant l\'huile d\'olive progressivement.',
                    'Ajuster l\'assaisonnement avec le jus de citron.',
                    'Réserver au frais 1 heure.',
                    'Servir avec des toasts de pain grillé.'
                ],
                'categoryId' => 'cat_005',
                'chefId' => 'user_002',
                'duration' => 15,
                'likesCount' => 36,
                'commentsCount' => 6,
                'favoritesCount' => 18,
                'rating' => 4.0
            ],
            
            // Végétarien
            [
                'recipeId' => 'recipe_011',
                'title' => 'Risotto aux Champignons',
                'imageUrl' => null,
                'description' => 'Risotto crémeux aux champignons de Paris et parmesan.',
                'ingredients' => [
                    '300g de riz arborio',
                    '300g de champignons de Paris',
                    '1 oignon',
                    '50cl de bouillon de légumes',
                    '10cl de vin blanc',
                    '50g de parmesan râpé',
                    '2 c. à soupe de beurre',
                    'Huile d\'olive',
                    'Persil',
                    'Sel et poivre'
                ],
                'steps' => [
                    'Émincer l\'oignon et faire revenir dans l\'huile.',
                    'Ajouter le riz et remuer 2 minutes.',
                    'Mouiller avec le vin blanc.',
                    'Ajouter le bouillon progressivement en remuant.',
                    'Faire revenir les champignons séparément.',
                    'Incorporer les champignons au risotto.',
                    'Ajouter le parmesan et le beurre.',
                    'Servir chaud avec du persil ciselé.'
                ],
                'categoryId' => 'cat_006',
                'chefId' => 'user_003',
                'duration' => 35,
                'likesCount' => 58,
                'commentsCount' => 13,
                'favoritesCount' => 29,
                'rating' => 4.4
            ],
            [
                'recipeId' => 'recipe_012',
                'title' => 'Curry de Légumes',
                'imageUrl' => null,
                'description' => 'Curry indien aux légumes de saison et lait de coco.',
                'ingredients' => [
                    '2 aubergines',
                    '2 courgettes',
                    '1 poivron rouge',
                    '1 oignon',
                    '2 tomates',
                    '40cl de lait de coco',
                    '2 c. à soupe de curry en poudre',
                    '2 gousses d\'ail',
                    'Gingembre frais',
                    'Huile de coco',
                    'Coriandre fraîche',
                    'Riz basmati (pour servir)'
                ],
                'steps' => [
                    'Couper tous les légumes en morceaux.',
                    'Faire revenir l\'oignon dans l\'huile de coco.',
                    'Ajouter l\'ail et le gingembre râpé.',
                    'Saupoudrer de curry et remuer.',
                    'Ajouter les légumes et les tomates.',
                    'Mouiller avec le lait de coco.',
                    'Laisser mijoter 25 minutes.',
                    'Servir avec du riz basmati et de la coriandre.'
                ],
                'categoryId' => 'cat_006',
                'chefId' => 'user_004',
                'duration' => 50,
                'likesCount' => 47,
                'commentsCount' => 10,
                'favoritesCount' => 24,
                'rating' => 4.2
            ],
            
            // Végan
            [
                'recipeId' => 'recipe_013',
                'title' => 'Buddha Bowl Quinoa',
                'imageUrl' => null,
                'description' => 'Bowl coloré au quinoa avec légumes rôtis et sauce tahini.',
                'ingredients' => [
                    '150g de quinoa',
                    '1 patate douce',
                    '1 brocoli',
                    '1 avocat',
                    '200g de pois chiches',
                    'Graines de courge',
                    'Tahini',
                    'Jus de citron',
                    'Huile d\'olive',
                    'Cumin',
                    'Sel et poivre'
                ],
                'steps' => [
                    'Cuire le quinoa selon les instructions.',
                    'Couper la patate douce en cubes et la faire rôtir.',
                    'Cuire le brocoli à la vapeur.',
                    'Rincer et égoutter les pois chiches.',
                    'Préparer la sauce : mélanger tahini, jus de citron et huile.',
                    'Disposer tous les ingrédients dans un bol.',
                    'Arroser de sauce et saupoudrer de graines.',
                    'Servir immédiatement.'
                ],
                'categoryId' => 'cat_007',
                'chefId' => 'user_001',
                'duration' => 40,
                'likesCount' => 62,
                'commentsCount' => 14,
                'favoritesCount' => 31,
                'rating' => 4.5
            ],
            [
                'recipeId' => 'recipe_014',
                'title' => 'Pâtes à la Crème de Noix de Cajou',
                'imageUrl' => null,
                'description' => 'Pâtes crémeuses avec sauce aux noix de cajou et légumes.',
                'ingredients' => [
                    '300g de pâtes',
                    '100g de noix de cajou',
                    '2 courgettes',
                    '1 oignon',
                    '2 gousses d\'ail',
                    '20cl d\'eau',
                    'Huile d\'olive',
                    'Basilic frais',
                    'Levure nutritionnelle',
                    'Sel et poivre'
                ],
                'steps' => [
                    'Faire tremper les noix de cajou 2 heures.',
                    'Cuire les pâtes selon les instructions.',
                    'Émincer l\'oignon et couper les courgettes.',
                    'Faire revenir les légumes dans l\'huile.',
                    'Mixer les noix de cajou avec l\'eau.',
                    'Ajouter la crème aux légumes.',
                    'Mélanger avec les pâtes.',
                    'Servir avec du basilic et de la levure.'
                ],
                'categoryId' => 'cat_007',
                'chefId' => 'user_002',
                'duration' => 30,
                'likesCount' => 44,
                'commentsCount' => 8,
                'favoritesCount' => 22,
                'rating' => 4.1
            ],
            
            // Sans gluten
            [
                'recipeId' => 'recipe_015',
                'title' => 'Pancakes à la Farine de Riz',
                'imageUrl' => null,
                'description' => 'Pancakes moelleux sans gluten à la farine de riz.',
                'ingredients' => [
                    '200g de farine de riz',
                    '2 œufs',
                    '30cl de lait d\'amande',
                    '2 c. à soupe de sucre',
                    '1 c. à café de levure chimique',
                    '1 pincée de sel',
                    'Huile de coco',
                    'Sirop d\'érable (pour servir)'
                ],
                'steps' => [
                    'Mélanger la farine, le sucre, la levure et le sel.',
                    'Battre les œufs et les incorporer.',
                    'Ajouter le lait d\'amande progressivement.',
                    'Laisser reposer la pâte 10 minutes.',
                    'Faire chauffer une poêle avec l\'huile de coco.',
                    'Verser des petites louches de pâte.',
                    'Cuire 2-3 minutes de chaque côté.',
                    'Servir avec du sirop d\'érable.'
                ],
                'categoryId' => 'cat_008',
                'chefId' => 'user_003',
                'duration' => 25,
                'likesCount' => 39,
                'commentsCount' => 7,
                'favoritesCount' => 19,
                'rating' => 4.0
            ],
            [
                'recipeId' => 'recipe_016',
                'title' => 'Tarte aux Pommes Sans Gluten',
                'imageUrl' => null,
                'description' => 'Tarte aux pommes avec pâte sans gluten à la farine de châtaigne.',
                'ingredients' => [
                    '200g de farine de châtaigne',
                    '100g de beurre',
                    '1 œuf',
                    '6 pommes',
                    '50g de sucre',
                    '1 c. à café de cannelle',
                    'Jus de citron',
                    'Confiture d\'abricot'
                ],
                'steps' => [
                    'Mélanger la farine avec le beurre et l\'œuf.',
                    'Former une boule de pâte et la réserver au frais.',
                    'Éplucher et couper les pommes en lamelles.',
                    'Arroser de jus de citron et saupoudrer de cannelle.',
                    'Étaler la pâte et la disposer dans un moule.',
                    'Disposer les pommes en rosace.',
                    'Cuire 35 minutes à 180°C.',
                    'Napper de confiture d\'abricot chaude.'
                ],
                'categoryId' => 'cat_008',
                'chefId' => 'user_004',
                'duration' => 60,
                'likesCount' => 51,
                'commentsCount' => 11,
                'favoritesCount' => 26,
                'rating' => 4.3
            ]
        ];

        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_categories()
    {
        // Créer une catégorie de test
        Category::create([
            'categoryId' => 'test_category',
            'name' => 'Test Category',
            'imageUrl' => 'https://example.com/test.jpg'
        ]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ]);
    }

    public function test_can_register_user()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/auth/register', $userData);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'Utilisateur créé avec succès'
                ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    public function test_can_login_user()
    {
        // Créer un utilisateur
        User::create([
            'userId' => 'test_user_id',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/auth/login', $loginData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Connexion réussie'
                ]);
    }
}

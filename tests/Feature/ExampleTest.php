<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Faker\Factory as Faker;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $token;

    protected $userId;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and store it in a property
        $faker = Faker::create();

    // Create a user using Faker
        $user = User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password') // Default password
        ]);

        $this->userId = $user->id;

        // Log in to get the token
        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $loginResponse->assertStatus(200)
                    ->assertJsonStructure([
                        'token',
                        'token_type',
                        'message'
                    ]);

        $this->token = $loginResponse->json('token');
    }

    /**
     * A basic test example.
     */

     public function test_user_registration_successful(): void
        {
            $response = $this->postJson('/api/auth/register', [
                'name' => 'muma',
                'email' => 'ngangmuma@gmail.com',
                'password' => 'muma1234',
                'password_confirmation' => 'muma1234',
            ]);

            $response->assertStatus(201)
                    ->assertJson([
                        'data' => [
                            'message' => 'Success',
                            'attributes' => [
                                'name' => 'muma',
                                'email' => 'ngangmuma@gmail.com',
                            ]
                        ]
                    ]);
        }

        public function test_user_login_successful(): void
        {
            // Create a user with a known password
            $user = User::factory()->create([
                'password' => bcrypt('password') // Adjust password as needed
            ]);
    
            $response = $this->postJson('/api/auth/login', [
                'email' => $user->email,
                'password' => 'password',
            ]);

            $this->token = $response->json('token');
    
            $response->assertStatus(200)
                     ->assertJson([
                         'data' => [
                             'message' => 'Success',
                         ],
                         'token' => $this->token,
                         'token_type' => 'Bearer'
                     ])
                     ->assertJsonStructure([
                         'token',
                         'token_type',
                         'message'
                     ]);
    
        }

    public function test_create_todo(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password') // Adjust password as needed
        ]);

        $response = $this->postJson("/api/v1/users/".$user->id."/todos", [
            'title' => 'New Todo',
            'description' => 'A description for the new todo',
        ], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'title' => 'New Todo',
                         'description' => 'A description for the new todo',
                         // 'dueDate' is expected to be null or omitted
                     ]
                 ])
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'title',
                         'description',
                         'dueDate'
                     ]
                 ]);
    }
}
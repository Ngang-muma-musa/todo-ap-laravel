<?php

namespace Tests\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;
use App\Repositories\UserRepository;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase;

    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Initialize the UserRepository instance
        $this->userRepository = new UserRepository();
    }

    public function test_create_user(): void
    {
        $userDetails = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123') // Ensure the password is hashed
        ];

        $user = $this->userRepository->createUser($userDetails);

        // Assert that the user is created
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userDetails['name'], $user->name);
        $this->assertEquals($userDetails['email'], $user->email);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_get_user_by_email(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => Hash::make('password123')
        ]);

        $retrievedUser = $this->userRepository->getUserByEmail('jane.doe@example.com');

        // Assert that the correct user is retrieved
        $this->assertInstanceOf(User::class, $retrievedUser);
        $this->assertEquals($user->id, $retrievedUser->id);
        $this->assertEquals($user->email, $retrievedUser->email);
    }
}

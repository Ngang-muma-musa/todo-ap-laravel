<?php

namespace Tests\Unit;
use App\Models\User;
use App\Models\Todo;
use App\Repositories\TodoRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;
use App\Repositories\UserRepository;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase;

    protected $userRepository;
    protected $todoRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Initialize the UserRepository instance
        $this->userRepository = new UserRepository();
        $this->todoRepository = new TodoRepository();
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

    // public function test_get_todos(): void
    // {
    //     // Create some todos for a user
    //     $userId = 1;
    //     Todo::factory()->create(['user_id' => $userId, 'title' => 'Todo 1']);
    //     Todo::factory()->create(['user_id' => $userId, 'title' => 'Todo 2']);
        
    //     $todos = $this->todoRepository->getTodos($userId);

    //     // Assert that the todos are retrieved
    //     $this->assertCount(2, $todos->items());
    //     $this->assertEquals('Todo 1', $todos->items()[0]->title);
    //     $this->assertEquals('Todo 2', $todos->items()[1]->title);
    // }

    // /**
    //  * Test the getTodo method.
    //  */
    // public function test_get_todo(): void
    // {
    //     $todo = Todo::factory()->create(['title' => 'Test Todo']);
    //     $retrievedTodo = $this->todoRepository->getTodo($todo->id);

    //     // Assert that the todo is retrieved correctly
    //     $this->assertInstanceOf(Todo::class, $retrievedTodo);
    //     $this->assertEquals($todo->id, $retrievedTodo->id);
    //     $this->assertEquals('Test Todo', $retrievedTodo->title);
    // }

    // /**
    //  * Test the getCompletedTodos method.
    //  */
    // public function test_get_completed_todos(): void
    // {
    //     // Create some todos
    //     Todo::factory()->create(['completed_at' => now()]);
    //     Todo::factory()->create(['completed_at' => null]);

    //     $completedTodos = $this->todoRepository->getCompletedTodos();

    //     // Assert that only completed todos are retrieved
    //     $this->assertCount(1, $completedTodos);
    //     $this->assertNotNull($completedTodos->first()->completed_at);
    // }

    // /**
    //  * Test the createTodo method.
    //  */
    // public function test_create_todo(): void
    // {
    //     $todoData = [
    //         'user_id' => 1,
    //         'title' => 'New Todo',
    //         'description' => 'A description for the new todo',
    //         'dueDate' => now()
    //     ];

    //     $todo = $this->todoRepository->createTodo($todoData);

    //     // Assert that the todo is created
    //     $this->assertInstanceOf(Todo::class, $todo);
    //     $this->assertEquals('New Todo', $todo->title);
    //     $this->assertEquals('A description for the new todo', $todo->description);
    // }

    // /**
    //  * Test the updateTodo method.
    //  */
    // public function test_update_todo(): void
    // {
    //     $todo = Todo::factory()->create(['title' => 'Old Title']);
        
    //     $updatedData = [
    //         'title' => 'Updated Title',
    //         'description' => 'Updated description'
    //     ];

    //     $updatedTodo = $this->todoRepository->updateTodo($updatedData, $todo->id);

    //     // Assert that the todo is updated
    //     $this->assertInstanceOf(Todo::class, $updatedTodo);
    //     $this->assertEquals('Updated Title', $updatedTodo->title);
    //     $this->assertEquals('Updated description', $updatedTodo->description);
    // }
}

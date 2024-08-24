<?php

namespace App\Repositories;

use App\Interfaces\TodoRepositoryInterface;
use App\Models\Todo;

class TodoRepository implements TodoRepositoryInterface
{
    public function getTodos($userId)
    {
        // Query to fetch todos for a specific user with related items and apply pagination
        return Todo::where('user_id', $userId)
            ->with('items') // Eager load related items
            ->paginate(); // Apply pagination
    }

    public function getTodo($userId,$id)
    
    {
        $todo = Todo::where('user_id', $userId)
        ->where('id', $id)
        ->with('items') // Eager load the related items
        ->firstOrFail(); // Retrieve a single model or fail

        return $todo;
    }

    public function getCompletedTodos()
    {
        return Todo::with('items') // Eager load related items
            ->whereNotNull('completed_at') // Filter todos that have a completed_at value
            ->get(); // Retrieve the collection
    }

    public function createTodo(array $body)
    {
        return Todo::create($body);
    }

    public function updateTodo(array $body,$userId, $id)
    {
        $todo = $this->getTodo($userId,$id);
        $todo->update($body);
        return $todo;
    }
}
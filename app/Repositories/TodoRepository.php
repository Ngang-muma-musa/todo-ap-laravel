<?php

namespace App\Repositories;

use App\Interfaces\TodoRepositoryInterface;
use App\Models\Todo;

class TodoRepository implements TodoRepositoryInterface
{
    public function getTodos()
    {
        return Todo::with('items')->paginate();
    }

    public function getTodo($id)
    {
        return Todo::with('todos')->findOrFail($id);
    }

    public function getCompletedTodos()
    {
        return Todo::with('items')
            ->whereDoesntHave('todos', function ($query) {
                $query->whereNull('completed_at');
            })
            ->get();
    }

    public function createTodo(array $body)
    {
        return Todo::create($body);
    }

    public function updateTodo(array $body, $id)
    {
        $todo = $this->getTodo($id);
        $todo->update($body);
        return $todo;
    }
}
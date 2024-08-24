<?php

namespace App\Interfaces;

interface TodoRepositoryInterface
{
    public function getTodos($userID);

    public function getTodo($id);

    public function getCompletedTodos();

    public function createTodo(array $body);

    public function updateTodo(array $body, $id);
}
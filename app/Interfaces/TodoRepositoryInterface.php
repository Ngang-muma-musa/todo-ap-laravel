<?php

namespace App\Interfaces;

interface TodoRepositoryInterface
{
    public function getTodos();

    public function getTodo($id);

    public function getCompletedTodos();

    public function createTodo(array $body);

    public function updateTodo(array $body, $id);
}
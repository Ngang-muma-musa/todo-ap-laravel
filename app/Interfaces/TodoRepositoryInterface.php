<?php

namespace App\Interfaces;

interface TodoRepositoryInterface
{
    public function getTodos($userID);

    public function getTodo($userId,$id);

    public function getCompletedTodos();

    public function createTodo(array $body);

    public function updateTodo(array $body,$userId, $id);
}
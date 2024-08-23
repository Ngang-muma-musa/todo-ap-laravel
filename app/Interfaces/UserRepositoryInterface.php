<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function createUser(array $details);

    public function getUserByEmail($email);
}

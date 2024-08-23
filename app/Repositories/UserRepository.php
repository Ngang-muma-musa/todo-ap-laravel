<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $userDetails)
    {
        return User::create($userDetails);
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}

<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\Repository;

class UserRepository implements Repository
{
    public function register($data)
    {
        $user = User::create($data);
        return $user;
    }
}

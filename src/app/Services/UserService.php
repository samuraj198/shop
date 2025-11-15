<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(private UserRepository $repository)
    {}

    public function register($data)
    {
        $user = $this->repository->register($data);
        Auth::login($user);

        return $user;
    }

    public function login($data)
    {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return true;
        }
        return false;
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return true;
        }
        return false;
    }
}

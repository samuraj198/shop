<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function register($data)
    {
        $user = User::create($data);
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

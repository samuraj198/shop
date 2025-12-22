<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class ProfileController extends Controller
{
    public function __construct(private UserService $userService)
    {}

    public function index()
    {
        $user = $this->userService->getRegisteredUser();

        return view('/', compact('user'));
    }
}

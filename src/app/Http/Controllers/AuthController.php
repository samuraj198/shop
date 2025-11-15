<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private UserService $service)
    {}
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $user = $this->service->register($data);

        return redirect()
            ->route('/')
            ->with('success', 'Вы успешно зарегистрировались. Вход выполнен!');
    }

    public function login(LoginUserRequest $request)
    {
        $data = $request->validated();
        $auth = $this->service->login($data);

        if ($auth === false) {
            return redirect()
                ->back()
                ->withErrors(['Возможно вы ввели неверные данные или такого пользователя не существует']);
        }
        return redirect()->route('/')->with('success', 'Авторизация прошла успешно');
    }
    public function logout()
    {
        $logout = $this->service->logout();
        if ($logout === false) {
            return redirect()->back()->withErrors(['При выходе из аккаунта произошла ошибка']);
        }
        return redirect()->route('/')->with('success', 'Вы успешно вышли из аккаунта');
    }
}

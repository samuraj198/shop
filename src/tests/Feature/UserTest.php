<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_register()
    {
        $data = [
            'name' => 'Daniil',
            'email' => 'daniil@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        $response = $this->post('/register', $data);
        $user = User::where('email', $data['email'])->first();

        $this->assertNotEquals($data['password'], $user->password);
        $this->assertTrue(Hash::check($data['password'], $user->password));
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());

        $response->assertRedirect('/');
    }

    public function test_login()
    {
        $data = [
            'email' => 'daniil@gmail.com',
            'password' => '12345678',
        ];
        $this->post('/register', [
            'name' => 'Daniil',
            'email' => 'daniil@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        Auth::logout();
        $this->assertGuest();

        $response = $this->post('/login', $data);
        $user = User::where('email', $data['email'])->first();
        $this->assertTrue(Hash::check($data['password'], $user->password));
        $this->assertEquals($user->id, Auth::id());
        $this->assertTrue(Auth::check());

        $response->assertRedirect('/');
    }

    public function test_logout()
    {
        $this->post('/register', [
            'name' => 'Daniil',
            'email' => 'daniil@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $this->assertAuthenticated();
        $response = $this->delete('/logout');
        $this->assertFalse(Auth::check());
        $response->assertRedirect('/');
    }
}

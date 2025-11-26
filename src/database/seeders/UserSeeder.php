<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!app()->environment('local', 'testing')) {
            $this->command->info('Сиды запускаются только в local/testing среде');
            return;
        }
        $users = [
            ['id' => 1, 'name' => 'Daniil', 'email' => 'test@mail.ru', 'password' => '123456'],
            ['id' => 2, 'name' => 'Oleg', 'email' => 'test123@mail.ru', 'password' => '12345678'],
            ['id' => 3, 'name' => 'Victor', 'email' => 'test321@mail.ru', 'password' => '12345600'],
        ];
        foreach ($users as $user) {
            if (!User::where('email', $user['email'])->exists()) {
                User::create($user);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'email' => 'local-admin@mail.com',
            'name' => 'администратор',
            'password' => Hash::make('password'),
        ]);

        $admin->createToken('api');

        User::factory()->count(9)->create();
    }
}

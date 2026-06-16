<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin',          'email' => 'admin@vivero.com',    'password' => 'admin1234'],
            ['name' => 'Juan Vendedor',  'email' => 'juan@vivero.com',     'password' => 'vendedor1234'],
            ['name' => 'Ana Vendedora',  'email' => 'ana@vivero.com',      'password' => 'vendedor1234'],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'name'       => $user['name'],
                'email'      => $user['email'],
                'password'   => Hash::make($user['password']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

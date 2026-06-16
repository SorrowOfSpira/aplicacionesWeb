<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ClientesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_AR');

        for ($i = 0; $i < 15; $i++) {
            DB::table('cliente')->insertOrIgnore([
                'nombre'     => $faker->firstName(),
                'apellido'   => $faker->lastName(),
                'email'      => $faker->unique()->safeEmail(),
                'password'   => Hash::make('password123'),
                'telefono'   => $faker->phoneNumber(),
                'direccion'  => $faker->streetAddress() . ', ' . $faker->city(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VentasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('detalleventa')->truncate();
        DB::table('venta')->truncate();

        $faker      = Faker::create('es_AR');
        $productos  = DB::table('productos')->pluck('precio', 'id')->toArray();
        $clienteIds = DB::table('cliente')->pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            $idventa = DB::table('venta')->insertGetId([
                'fecha'     => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'idcliente' => $faker->randomElement($clienteIds),
            ]);

            $productosVenta = $faker->randomElements(array_keys($productos), $faker->numberBetween(1, 4));

            foreach ($productosVenta as $idproducto) {
                DB::table('detalleventa')->insert([
                    'idventa'        => $idventa,
                    'idproducto'     => $idproducto,
                    'cantidad'       => $faker->numberBetween(1, 5),
                    'preciounitario' => (int) $productos[$idproducto],
                ]);
            }
        }
    }
}

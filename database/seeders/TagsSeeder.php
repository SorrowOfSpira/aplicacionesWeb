<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Suculentas',
            'Cactus',
            'Tropicales',
            'Aromáticas',
            'Flores',
            'Árboles',
            'Helechos',
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'nombre'     => $tag,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

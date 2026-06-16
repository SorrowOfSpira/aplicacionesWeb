<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['nombre' => 'Aloe Vera', 'nombre_cientifico' => 'Aloe barbadensis', 'precio' => 1200, 'tags' => [1]],
            ['nombre' => 'Echeveria', 'nombre_cientifico' => 'Echeveria elegans', 'precio' => 800, 'tags' => [1]],
            ['nombre' => 'Cactus San Pedro', 'nombre_cientifico' => 'Echinopsis pachanoi', 'precio' => 2500, 'tags' => [2]],
            ['nombre' => 'Cactus Nopal', 'nombre_cientifico' => 'Opuntia ficus-indica', 'precio' => 1500, 'tags' => [2]],
            ['nombre' => 'Monstera', 'nombre_cientifico' => 'Monstera deliciosa', 'precio' => 3500, 'tags' => [3]],
            ['nombre' => 'Potus', 'nombre_cientifico' => 'Epipremnum aureum', 'precio' => 900, 'tags' => [3]],
            ['nombre' => 'Lavanda', 'nombre_cientifico' => 'Lavandula angustifolia', 'precio' => 1100, 'tags' => [4]],
            ['nombre' => 'Menta', 'nombre_cientifico' => 'Mentha spicata', 'precio' => 600, 'tags' => [4]],
            ['nombre' => 'Romero', 'nombre_cientifico' => 'Salvia rosmarinus', 'precio' => 700, 'tags' => [4]],
            ['nombre' => 'Rosa', 'nombre_cientifico' => 'Rosa canina', 'precio' => 1800, 'tags' => [5]],
            ['nombre' => 'Girasol', 'nombre_cientifico' => 'Helianthus annuus', 'precio' => 950, 'tags' => [5]],
            ['nombre' => 'Jazmín', 'nombre_cientifico' => 'Jasminum officinale', 'precio' => 1300, 'tags' => [5]],
            ['nombre' => 'Pino', 'nombre_cientifico' => 'Pinus radiata', 'precio' => 4500, 'tags' => [6]],
            ['nombre' => 'Helecho Boston', 'nombre_cientifico' => 'Nephrolepis exaltata', 'precio' => 1600, 'tags' => [7]],
            ['nombre' => 'Helecho Palma', 'nombre_cientifico' => 'Cycas revoluta', 'precio' => 2200, 'tags' => [7]],
        ];

        foreach ($productos as $data) {
            $id = DB::table('productos')->insertGetId([
                'nombre'           => $data['nombre'],
                'nombre_cientifico'=> $data['nombre_cientifico'],
                'precio'           => $data['precio'],
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            foreach ($data['tags'] as $tagId) {
                DB::table('producto_tag')->insert([
                    'producto_id' => $id,
                    'tag_id'      => $tagId,
                ]);
            }
        }
    }
}

<?php

use App\MateriaWall;
use Illuminate\Database\Seeder;

class MaterialWallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $material_walls = array(
            'Lámina','Madera','Carrizo','Adobe','Ladrillo','Material de desecho','Lamina de carton','Lamina de asbesto o metaloca','Tabique','Piedra','Material de concreto','Palma','Bambu'
        );

        foreach ($material_walls as $material) {
            $wall = new MateriaWall;
            $wall->name = $material;
            $wall->save();
        }
    }
}

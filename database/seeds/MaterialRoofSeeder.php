<?php

use App\MaterialRoof;
use Illuminate\Database\Seeder;

class MaterialRoofSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $material_roofs = array(
            'Lámina','Madera','Carrizo','Adobe','Ladrillo','Material de desecho','Lamina de carton','Lamina de asbesto o metaloca','Tabique','Piedra','Material de concreto','Palma','Bambu'
        );

        foreach ($material_roofs as $material) {
            $roof = new MaterialRoof;
            $roof->name = $material;
            $roof->save();
        }
    }
}

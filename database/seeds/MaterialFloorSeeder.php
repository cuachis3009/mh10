<?php

use App\MaterialFloor;
use Illuminate\Database\Seeder;

class MaterialFloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $material_floors = array(
            'Tierra','Cemento','Loseta','Madera','Mosaico'
        );

        foreach ($material_floors as $material) {
            $floor = new MaterialFloor;
            $floor->name = $material;
            $floor->save();
        }

    }
}

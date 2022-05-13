<?php

use App\WaterHouse;
use Illuminate\Database\Seeder;

class WaterHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $waters = array(
            'Agua entubada dentro de la vivienda','Agua entubada que acarrea','Agua de pipa'
        );

        foreach ($waters as $w) {
            $wa = new WaterHouse;
            $wa->name = $w;
            $wa->save();
        }

    }
}

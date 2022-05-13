<?php

use App\ProjectType;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        
        $projets_type = array("nuevo","fortalecimiento");
        foreach ($projets_type as $pt) {
            $type = new ProjectType;
            $type->name = $pt;
            $type->save();
        }

    }
}

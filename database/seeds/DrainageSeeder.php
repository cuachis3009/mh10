<?php

use App\Drainage;
use Illuminate\Database\Seeder;

class DrainageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $drains = array(
            'Red publica','Fosa','Tuberia'
        );

        foreach ($drains as $drain) {
            $d = new Drainage;
            $d->name = $drain;
            $d->save();
        }

    }
}

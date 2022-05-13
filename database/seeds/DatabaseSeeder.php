<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PeriodSeeder::class);
        $this->call(ProjectTypeSeeder::class);
        $this->call(PeriodProjectTypeSeeder::class);
        $this->call(MaterialWallSeeder::class);
        $this->call(MaterialRoofSeeder::class);
        $this->call(MaterialFloorSeeder::class);
        $this->call(WaterHouseSeeder::class);
        $this->call(DrainageSeeder::class);
        $this->call(RelationShipSeeder::class);
    }
}

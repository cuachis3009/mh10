<?php

use App\Period;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $period = new Period;
        $period->name = "Periodo 2022";
        $period->year = 2022;
        $period->active = 1;
        $period->save();
    }
}

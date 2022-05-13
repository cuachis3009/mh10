<?php

use App\Period;
use App\ProjectType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $period = Period::where("active",1)->first();
        $types = ProjectType::all();
        foreach ($types as $t) {
            DB::table("period_project_type")->insert([
                "period_id" => $period->id,
                "project_type_id" => $t->id
            ]);
        }
    }
}

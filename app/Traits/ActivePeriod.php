<?php 

namespace App\Traits;

use App\Period;

trait ActivePeriod{
    protected function getPeriod($year){
        $period = Period::where(["year" => $year,"active" => true])->with("types")->first();
        return $period;
    }
}

?>
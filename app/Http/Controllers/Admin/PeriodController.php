<?php

namespace App\Http\Controllers\Admin;

use App\Period;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeriodController extends Controller{

    public function changePeriod($year){
        /**Validamos que exista el periodo al que tratan de ingresar*/
        $period = Period::where('year',$year)->get()->first();
        if($period){
            session(['year' => (int)$year]);
        }else{
            $year = session('year');
        }

        return redirect()->route('admin.'.$year.'.dashboard');
    }

}

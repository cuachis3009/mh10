<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Utileria
{
    public function validaPeriodoProyecto($slug)
    {
        $fecha = Carbon::now();
        $fInicio = Carbon::createFromFormat('Y-m-d H:i:s', '2022-05-03 08:00:00');
        $fFin = Carbon::createFromFormat('Y-m-d H:i:s', '2022-05-25 23:59:59');
        
        /*Log::info('*************************');
        Log::info($fecha);
        Log::info($fInicio);
        Log::info($fecha->gte($fInicio));
        Log::info($fFin);
        Log::info($fecha->lte($fFin));
        */
        $check = false;
        if (($fecha->gte($fInicio)) and ($fecha->lte($fFin))) {
            $check = true;
        } else {
            $check = false;
            Log::info('*************************');
            Log::info($fecha);         
            Log::info("Project slug: " . $slug);
        }
        return $check;
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Period;

class ValidateProjecType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        $url = explode("/",$request->path());

        $period = Period::where([
            'year' => $url[0],
            'active' => true 
        ])
        ->with("types")
        ->first();

        $pass = false;
        foreach ($period->types as $type) {
            if($type->name == $request->type_project){
                $pass = true;
                break;
            }
        }

        if($pass){
            return $next($request);
        }else{
            return redirect()->route($period->year.".home");
        }
    }
}

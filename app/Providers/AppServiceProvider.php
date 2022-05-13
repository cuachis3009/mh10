<?php

namespace App\Providers;

use App\Period;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('APP_ENV') === 'production') {
            $this->app['url']->forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        if(!session()->has('year')){
            $period = Period::where('year',2022)->get()->first();
            session(['year' => $period->year]);
            session(['period_id' => $period->id]);
        }
        Carbon::setLocale("es");
    }
}

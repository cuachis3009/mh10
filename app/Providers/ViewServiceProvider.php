<?php

namespace App\Providers;

use App\Period;
use App\ProjectType;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(){
        View::composer('admin.template.admin', function ($view) {
            $project_types = ProjectType::whereHas('periods',function($query){
                $query->where('year',session('year'));
            })->get();
            
            $years = Period::select('year')->get();

            $view->with(['project_types' => $project_types,'years' => $years]);
        });
    }
}

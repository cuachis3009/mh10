<?php

use App\Period;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/","Y2022\ProjectController@index")->name("home.app");
Route::get('admin/period/change/{year}','Admin\PeriodController@changePeriod')->name('admin.period.change');

/**Link de resulados */
Route::get('/resultados','HomeController@resultados');

/***************************************************** A D M I N  L O G I N  R O U T E S ************************************/

Route::group(['prefix' => 'admin','as' => 'admin.'],function(){
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
});

/*Route::group(["prefix" => "admin","as" => "admin","namespace" => "admin"],function(){
    Route::get("project/{type_project}/pdf/{slug}","ProjectController@createPdf")
    ->name("project.pdf");

    Route::get("project/export","ProjectController@exportToExcel");
});*/

/***************************************************** 2 0 2 2 ***************************************************/

Route::group(["prefix" => "2022", "as" => "2022.","namespace" => "Y2022","middleware" => ["app.disable"]],function(){

    /** Project Routes */
    Route::post("project/{type_project}/create","ProjectController@create")
    ->middleware("validate.project.type")
    ->name("project.create");

    Route::get("project/{type_project}/complete/{slug}","ProjectController@completeProjectInfo")
    ->middleware("validate.project.type")
    ->name("project.complete");

    Route::post("project/{type_project}/finish/{slug}","ProjectController@finishProject")
    ->name("project.finish");

    Route::get("project/{type_project}/succesfully/{slug}","ProjectController@succesfully")
    ->name("project.succesfully");

    Route::get("project/{type_project}/pdf/{slug}","ProjectController@downloadPdf")
    ->name("project.pdf");

    //Route::post("project/getConocimiento/","ProjectController@getConocimiento");

    Route::post("project/{type_project}/getConocimiento","ProjectController@getConocimiento");

    Route::post("project/{type_project}/getSede","ProjectController@getSede");

    /** Members routes */

    Route::get("member/{type_project}/create/{slug}","MemberController@create")
    ->name("member.create");

    Route::post("member/{type_project}/store/{slug}","MemberController@store")
    ->name("member.store");

    Route::get("member/{type_project}/documents/{slug}","MemberController@documents")
    ->name("member.documents");

    Route::post("member/{type_project}/complete-documents/{slug}","MemberController@completeDocuments")
    ->name("member.complete-documents");

});

/**Se quito del middleware de disable app porque se utiliza en el admin*/
Route::post("2022/member/getZap/{type}","Y2022\MemberController@getZap");



/***************************************************** Fin 2 0 2 0 ***************************************************/

Route::post('/member/validate-curp','Y2022\MemberController@validateCurp')->name('member.validateCurp')->middleware("app.disable");

//Route::get('/home', 'HomeController@index')->name('home');

/****************************************************** T E S T  R O U T E S ******************************************/


/**Estas rutas no se deben de activar ya que fueron las que utilizaron para hacer el primer filtro para el comite dictaminador */
/*Route::get("/test",function(){
    $p = new App\Http\Controllers\Y2022\ProjectController;
    return $p->getNextFolio(1,1);
});

Route::get("2022/project/iterate/verify-docs/{period}/{type}/{folio?}","Y2022\ProjectController@validateProject")->name("2022.project.validate-project");*/

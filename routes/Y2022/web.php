<?php 

use Illuminate\Support\Facades\Route;

// Es siguiente listado de rutas corresponde a la convocatoria del año 2022, para rutas del otro año se debe crear otro archivo
/** -------------------------------------------------- ADMIN ROUTES ---------------------------------------------------- */

Route::group(['prefix' => 'admin/2022',"as" => 'admin.2022.','namespace' => 'Admin\Y2022','middleware' => 'auth'],function(){

    /** ========================= P R O J E C T S ===================================== */

    Route::get('/','ProjectController@index')->name('dashboard');
    /**See project */
    Route::get('project/show/{slug}','ProjectController@show')->name('show');
    /**Search projects */
    Route::post('project/search','ProjectController@search')->name('search');
    /**Project not found */
    Route::get('project/not-found',function(){
        return view('admin.2022.project.not-found');
    })->name('not-found');
    /**Pdf acuse de registro */
    Route::get("project/{type_project}/pdf/{slug}","ProjectController@createPdf")->name("project.pdf");
    /**Convenio */
    Route::get('projects/docs/convenio/{slug}','ProjectController@convenio')->name('project.convenio');
    /**Carta */
    Route::get('projects/docs/carta/{slug}','ProjectController@carta')->name('project.carta');
    /**Tarjeta */
    Route::get('projects/docs/tarjeta/{slug}','ProjectController@tarjeta')->name('project.tarjeta');
    /**Download all docs from project */
    Route::post("project/documents/all",'ProjectController@downloadAllDocs')->name('project.download-all-docs');
    /**Asignar datos bancarios a proyecto */
    Route::post("project/bank-details/{slug}","ProjectController@bankDetails")->name('project.bank-details');
    /** Psron con proyecto */
    Route::get('project/padron-with-project',"ProjectController@exportPadron");

    /** ========================= M E M B E R  ===================================== */

    Route::get('member/edit/{slug}','MemberController@edit')->name('member.edit');
    /**Update member info */
    Route::post('member/update/{slug}','MemberController@update')->name('member.update');
    /**Zonas zap */
    Route::get('member/zap','MemberController@zapZones')->name('member.zap-zones');

    /** ==================== C O M P R O B A T I O N ======================================= */
    Route::get("comprobation","ComprobationController@index")->name('comprobation.index');
    Route::get("comprobation/project/{slug}","ComprobationController@create")->name('comprobation.project');
    /**Save comprobation */
    Route::post('comprobation/project/save/{slug}','ComprobationController@store')->name('comprobation.save');
    /**Delete comprobation */
    Route::post('comprobation/project/destroy','ComprobationController@destroy')->name('comprobation.destroy');
    /**Export report comprobation */
    Route::post('comprobation/report','ComprobationController@export')->name('comprobation.export');


    /**Reportes */
    Route::get('project/report/convenios','ProjectController@exportReportConvenios');
});


?>
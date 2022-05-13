<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposNuevosToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->text('cat_estandar_id')->nullable(true)->after('productive_activity');
            $table->text('objective')->nullable(true)->after('project_description');
            $table->text('product_description')->nullable(true)->after('objective');            
            $table->text('activity_description')->nullable(true)->after('product_description');
            $table->text('activity_description_emp_perm')->nullable(true)->after('activity_description');
            $table->text('activity_description_emp_temp1')->nullable(true)->after('activity_description_emp_perm');
            $table->text('activity_description_emp_temp2')->nullable(true)->after('activity_description_emp_temp1');
            $table->text('proces_description')->nullable(true)->after('activity_description_emp_temp2');            
            $table->text("street")->nullable(true)->after('proces_description');
            $table->text("exterior_number")->nullable(true)->after('street');
            $table->text("interior_number")->nullable(true)->after('exterior_number');
            $table->text("colonia")->nullable(true)->after('interior_number');
            $table->text("postal_code")->nullable(true)->after('colonia');
            $table->text("cat_municipio_id")->nullable(true)->after('postal_code');
            $table->text("cat_localidad_id")->nullable(true)->after('cat_municipio_id');
            $table->text("cat_colonia_id")->nullable(true)->after('cat_localidad_id');
            $table->text("cat_tipo_asentamiento_id")->nullable(true)->after('cat_colonia_id');
            $table->text("referencia_domicilio")->nullable(true)->after('cat_tipo_asentamiento_id');
            $table->string('cat_modalidad_local')->nullable(true)->after('cat_tipo_asentamiento_id');
            $table->string('esp_modalidad_local')->nullable(true)->after('cat_modalidad_local');
            $table->string('experience_time')->nullable(true)->after('cat_modalidad_local');
    
                       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->dropColumn(['referencia_domicilio','experience_time','objective','product_description','activity_description','activity_description_emp_perm',
            'activity_description_emp_temp1','activity_description_emp_temp2','proces_description','street','exterior_number',
            'interior_number','colonia','postal_code','cat_municipio_id','cat_localidad_id','cat_colonia_id','cat_tipo_asentamiento_id','cat_modalidad_local','esp_modalidad_local']);
        });
    }
}

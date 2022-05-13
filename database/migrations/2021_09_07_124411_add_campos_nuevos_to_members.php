<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposNuevosToMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('cat_municipio_id_indigena')->nullable()->after('cat_municipio_id');
            $table->string('rfc')->after('sex');
            $table->string('marital_status')->after('rfc');
            $table->string('status_rfc')->after('marital_status');
            $table->string('discharge_date_rfc')->after('status_rfc');
            $table->integer("cat_tipo_vialidad_id")->after("cat_colonia_id");            
            $table->integer("cat_tipo_asentamiento_id")->after("cat_tipo_vialidad_id");
            $table->text("referencia_domicilio")->nullable(true)->after('cat_tipo_asentamiento_id');
            $table->integer("cat_estudios_id")->after("cat_tipo_asentamiento_id");
            $table->integer("cat_loc_col_id")->after("cat_estudios_id");       
            $table->integer("age")->after("sex");            
            //$table->string('colonia')->nullable(true)->change();
            //$table->string('municipio')->nullable(true)->change();
            //$table->string('estado')->nullable(true)->change();
            
            /*$table->foreign('status_rfc')->references('id')->on('cat_rfc_status');
            $table->foreign('marital_status')->references('id')->on('cat_marital_status');            
            $table->foreign('cat_tipo_vialidad_id')->references('id')->on('cat_tipo_vialidad');
            $table->foreign('cat_tipo_asentamiento_id')->references('id')->on('cat_tipo_asentamiento');*/
        });
       }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['age','referencia_domicilio','cat_loc_col_id','cat_estudios_id','cat_municipio_id_indigena','rfc', 'marital_status', 'status_rfc','discharge_date_rfc','cat_tipo_vialidad_id','cat_tipo_asentamiento_id']);
        });     
    }
}

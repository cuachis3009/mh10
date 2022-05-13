<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposNuevosToCatMunicipio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cat_municipio', function (Blueprint $table) {
            //
            $table->boolean('indigena')->after('municipio');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cat_municipio', function (Blueprint $table) {
            //
            $table->dropColumn(['indigena']);
        });
    }
}

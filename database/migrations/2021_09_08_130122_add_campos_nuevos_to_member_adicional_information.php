<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposNuevosToMemberAdicionalInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_adicional_information', function (Blueprint $table) {
            //
            $table->string('specify_house')->nullable(true)->after('house_adquisition_id');
            //$table->foreign('house_adquisition_id')->references('id')->on('house_adquisition');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_adicional_information', function (Blueprint $table) {
            //
            $table->dropColumn(['specify_house',]);
        });
    }
}

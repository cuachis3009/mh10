<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposNuevosToMemberDependents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_dependents', function (Blueprint $table) {
            //
            $table->string('student')->after('beneficiary_social_program');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_dependents', function (Blueprint $table) {
            //
            $table->dropColumn(['student']);
        });
    }
}

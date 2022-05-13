<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDenyToProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text("municipio")->nullable()->after('status');
            $table->boolean('same_member_previous_project')->nullable()->after('member_benefited_other_year');
            $table->text('deny')->after('same_member_previous_project')->nullable();
            $table->boolean('member_count_same_project')->nullable()->after('deny');
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
            $table->dropColumn(['municipio','same_member_previous_project','deny','member_count_same_project']);
        });
    }
}

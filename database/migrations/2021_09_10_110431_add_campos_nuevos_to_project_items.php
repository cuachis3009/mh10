<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposNuevosToProjectItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_items', function (Blueprint $table) {
            //        
            $table->string('unit')->nullable(false)->after('item');
            $table->integer('total_cost')->nullable(false)->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_items', function (Blueprint $table) {
            //
            $table->dropColumn(['unit','total_cost']);
        });
    }
}

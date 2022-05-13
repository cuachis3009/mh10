<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatLocColTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_loc_col', function (Blueprint $table) {
            $table->id();
            $table->string("clave_municipio",10)->nullable();
            $table->string("clave_loc_col",10)->nullable();
            $table->string("loc_col")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_loc_col');
    }
}

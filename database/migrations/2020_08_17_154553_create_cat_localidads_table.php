<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatLocalidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_localidad', function (Blueprint $table) {
            $table->id();
            $table->integer("municipio_id")->nullable();
            $table->string("clave_municipio",10)->nullable();
            $table->string("clave_localidad",10)->nullable();
            $table->text("localidad")->nullable();
            $table->string("ambito",5)->nullable();
            $table->text("mapa")->nullable();
            $table->text("lat_decimal")->nullable();
            $table->text("lon_decimal")->nullable();
            $table->boolean("zap")->nullable();
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
        Schema::dropIfExists('cat_localidad');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatColoniasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_colonia', function (Blueprint $table) {
            $table->id();
            $table->string("id_municipio",10)->nullable();
            $table->string("id_localidad",10)->nullable();
            $table->string("id_colonia",10)->nullable();
            $table->text("colonia")->nullable();
            $table->integer("cp")->nullable();
            $table->text("tipo_colonia")->nullable();
            $table->text("mapa")->nullable();
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
        Schema::dropIfExists('cat_colonia');
    }
}

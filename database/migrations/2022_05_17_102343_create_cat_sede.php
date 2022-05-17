<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatSede extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_sede', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_municipio_id');
            $table->foreign('cat_municipio_id')->references('id')->on('cat_municipio')->onDelete('cascade');
            $table->unsignedBigInteger('cat_curso_id');
            $table->foreign('cat_curso_id')->references('id')->on('cat_curso')->onDelete('cascade');
            $table->string("domicilio");
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
        Schema::dropIfExists('cat_sede');
    }
}

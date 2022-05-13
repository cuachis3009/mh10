<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectConocimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_conocimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyect_id');
            $table->unsignedBigInteger('cat_conocimiento_id');
            $table->foreign('proyect_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('cat_conocimiento_id')->references('id')->on('cat_conocimiento')->onDelete('cascade');
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
        Schema::dropIfExists('project_conocimiento');
    }
}

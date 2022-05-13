<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoCrossingMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_crossing_members', function (Blueprint $table) {
            $table->id();
            $table->year('periodo');
            $table->integer('folio');
            $table->integer('convocatoria');
            $table->text('curp')->nullable();
            $table->text('clave_elector')->nullable();
            $table->text('rfc')->nullable();
            $table->text('nombre')->nullable();
            $table->text('apellido_paterno')->nullable();
            $table->text('apellido_materno')->nullable();
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
        Schema::dropIfExists('info_crossing_members');
    }
}

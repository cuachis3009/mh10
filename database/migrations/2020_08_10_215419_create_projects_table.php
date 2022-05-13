<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer("period_id");
            $table->integer("project_type_id");
            $table->integer("folio")->nullable();
            $table->integer("status")->default(0);
            $table->text("slug");
            $table->integer("number_members");
            $table->text("name_group")->nullable();
            $table->integer("giro_id")->nullable();
            $table->text("productive_activity")->nullable();
            $table->text("project_description")->nullable();
            $table->text("comunity_service_description")->nullable();
            $table->boolean("hire_more_people")->nullable();
            $table->boolean("project_exist")->nullable();
            $table->integer("resource_id")->nullable();
            $table->timestamps();

            /** Combinacion de campo unicos */
            //$table->unique(['folio_preregistro','cat_periodo_id','cat_tipo_convocatoria_id'], 'folio_preregistro');
            $table->unique(['folio','period_id','project_type_id'], 'folio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

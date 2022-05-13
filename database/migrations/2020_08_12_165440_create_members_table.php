<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->integer("project_id");
            $table->text("slug");
            $table->boolean("web_registration");
            $table->text("name");
            $table->text("father_surname");
            $table->text("mother_surname");
            $table->text("curp");
            $table->text("official_id_clave");
            $table->year("officlal_id_year_expiration");
            $table->text("cellphone_number");
            $table->text("house_phonenumber")->nullable();
            $table->text("adicional_phonenumber")->nullable();
            $table->string("email")->nullable();
            $table->integer("sex");
            $table->text("street");
            $table->text("exterior_number");
            $table->text("interior_number")->nullable();
            $table->text("colonia");
            $table->text("postal_code");
            $table->text("municipio");
            $table->text("estado");
            /*$table->boolean("doc_official_id");
            $table->boolean("doc_curp");
            $table->boolean("");*/
            //$table->text("approximate_income");
            //$table->integer("water_type");
            $table->timestamps();
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}

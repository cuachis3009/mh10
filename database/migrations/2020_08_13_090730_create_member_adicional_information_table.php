<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAdicionalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_adicional_information', function (Blueprint $table) {
            $table->id();
            $table->integer("member_id");
            $table->boolean("has_disability")->nullable();
            $table->text("specify_disability")->nullable();
            $table->integer("water_type")->nullable();
            $table->boolean("has_kitchen")->nullable();
            $table->integer("number_rooms_as_bedroom")->nullable();
            $table->integer("number_of_bathrooms")->nullable();
            $table->integer("drainage_id")->nullable();
            $table->integer("home_light_id")->nullable();
            $table->integer("house_adquisition_id")->nullable();
            $table->integer("people_live_in_house")->nullable();
            $table->boolean("pregnant_person_in_house")->nullable();
            $table->integer("monthly_income")->nullable();
            $table->integer("health_care_service_id")->nullable();
            $table->boolean("returned_migrant")->nullable();
            $table->boolean("can_read_write")->nullable();
            $table->text("employment")->nullable();
            $table->boolean("group_indigena")->nullable();
            $table->integer("years_experience_project")->nullable();
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
        Schema::dropIfExists('member_adicional_information');
    }
}

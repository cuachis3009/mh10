<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberDependentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_dependents', function (Blueprint $table) {
            $table->id();
            $table->integer("member_id");
            $table->text("fullname");
            $table->integer("relation_ship_id");
            $table->boolean("newborn");
            $table->integer("age_old");
            $table->boolean("has_disability")->nullable();
            $table->text("specify_disability")->nullable();
            $table->boolean("older");
            $table->text("beneficiary_social_program");
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
        Schema::dropIfExists('member_dependents');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZapFieldsToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->integer("cat_colonia_id")->nullable()->after("estado");
            $table->integer("cat_localidad_id")->nullable()->after("estado");
            $table->integer("cat_municipio_id")->nullable()->after("estado");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(["cat_municipio_id","cat_localidad_id","cat_colonia_id"]);
        });
    }
}

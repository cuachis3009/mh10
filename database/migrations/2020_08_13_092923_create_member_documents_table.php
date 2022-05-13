<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_documents', function (Blueprint $table) {
            $table->id();
            $table->integer("member_id");
            $table->integer("doc_official_id")->nullable();
            $table->integer("doc_curp")->nullable();
            $table->integer("doc_comprobante_domicilio")->nullable();
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
        Schema::dropIfExists('member_documents');
    }
}

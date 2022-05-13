<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposNuevosToMemberDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_documents', function (Blueprint $table) {
            //
            $table->integer('doc_carta')->nullable()->after('member_id');
            $table->integer('doc_constancia')->nullable()->after('doc_curp');
            $table->dropColumn(['doc_comprobante_domicilio']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_documents', function (Blueprint $table) {
            //
            $table->dropColumn(['doc_carta','doc_constancia']);
            $table->string('doc_comprobante_domicilio')->nullable()->after('doc_curp');
        });
    }
}

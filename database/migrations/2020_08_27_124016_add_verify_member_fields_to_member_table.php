<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifyMemberFieldsToMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('full_documentation')->nullable()->after('cat_colonia_id');
            $table->boolean('member_duplicate_same_project')->default(false)->after('full_documentation');
            $table->boolean('member_duplicate_other_projects')->default(false)->after('member_duplicate_same_project');
            $table->boolean('member_benefited_other_year')->default(false)->after('member_duplicate_other_projects');
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
            $table->dropColumn(['full_documentation','member_duplicate_same_project','member_duplicate_other_projects','member_benefited_other_year']);
        });
    }
}

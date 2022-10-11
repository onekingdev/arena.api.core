<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFormatFieldsIfSoundblockProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects", function (Blueprint $objTable){
            $objTable->renameColumn("project_format_id", "format_id");
            $objTable->renameColumn("project_format_uuid", "format_uuid");
            $objTable->string("project_artist", 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects", function (Blueprint $objTable){
            $objTable->renameColumn("format_id", "project_format_id");
            $objTable->renameColumn("format_uuid", "project_format_uuid");
            $objTable->string("project_artist", 255)->nullable()->change();
        });
    }
}

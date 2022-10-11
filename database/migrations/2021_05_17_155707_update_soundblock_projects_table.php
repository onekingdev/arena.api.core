<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSoundblockProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects", function (Blueprint $objTable){
            $objTable->renameColumn("project_type_id", "project_format_id")->index("idx_project-format-id");
            $objTable->renameColumn("project_type_uuid", "project_format_uuid")->index("idx_project-format-uuid");

            $objTable->string("project_artist", 255)->after("project_upc")->nullable();
            $objTable->string("project_title_release", 255)->after("project_artist")->nullable();
            $objTable->unsignedTinyInteger("project_volumes")->after("project_title_release");
            $objTable->string("project_recording_location", 255)->after("project_volumes")->nullable();
            $objTable->string("project_recording_year", 4)->after("project_recording_location")->nullable();
            $objTable->string("project_copyright_name", 255)->after("project_recording_year");
            $objTable->string("project_copyright_year", 4)->after("project_copyright_name");
            $objTable->boolean("flag_project_compilation")->after("project_copyright_year");
            $objTable->boolean("flag_project_explicit")->after("flag_project_compilation");

            $objTable->string("project_title", 255)->change()->index("idx_project-title");
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
            $objTable->renameColumn("project_format_id", "project_type_id");
            $objTable->dropIndex("idx_project-format-id");
            $objTable->renameColumn("project_format_uuid", "project_type_uuid");
            $objTable->dropIndex("idx_project-format-uuid");

            $objTable->removeColumn("project_artist");
            $objTable->removeColumn("project_title_release");
            $objTable->removeColumn("project_volumes");
            $objTable->removeColumn("project_recording_location");
            $objTable->removeColumn("project_recording_year");
            $objTable->removeColumn("project_copyright_name");
            $objTable->removeColumn("project_copyright_year");
            $objTable->removeColumn("flag_project_compilation");
            $objTable->removeColumn("flag_project_explicit");

            $objTable->string("project_title", 175)->change();
            $objTable->dropIndex("idx_project-title");
        });
    }
}

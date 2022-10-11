<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSoundblockProjectsTypesToFormats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_data_projects_types", function (Blueprint $objTable) {
            $objTable->renameColumn("row_id", "data_id");
            $objTable->renameIndex("idx_row-id_stamp-deleted-at", "idx_data-id_stamp-deleted-at");

            $objTable->renameColumn("row_uuid", "data_uuid");
            $objTable->renameIndex("idx_row-uuid_stamp-deleted-at", "idx_data-uuid_stamp-deleted-at");

            $objTable->renameColumn("project_type_name", "data_format");
            $objTable->renameIndex("idx_project-type-name_stamp-deleted-at", "idx_data-format_stamp-deleted-at");

            $objTable->unique("data_id", "uidx_data-id");
            $objTable->unique("data_uuid", "uidx_data-uuid");
            $objTable->unique("data_format", "uidx_data-format");
            $objTable->unique(["data_id", "data_format"], "uidx_data-id_data-format");
            $objTable->unique(["data_uuid", "data_format"], "uidx_data-uuid_data-format");
        });
        Schema::rename("soundblock_data_projects_types", "soundblock_data_projects_formats");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_data_projects_formats", function (Blueprint $objTable) {
            $objTable->renameColumn("data_id", "row_id");
            $objTable->renameIndex("idx_data-id_stamp-deleted-at", "idx_row-id_stamp-deleted-at");

            $objTable->renameColumn("data_uuid", "row_uuid");
            $objTable->renameIndex("idx_data-uuid_stamp-deleted-at", "idx_row-uuid_stamp-deleted-at");

            $objTable->renameColumn("data_format", "project_type_name");
            $objTable->renameIndex("idx_data-format_stamp-deleted-at", "idx_project-type-name_stamp-deleted-at");

            $objTable->unsignedBigInteger("project_type_id");
            $objTable->uuid("project_type_uuid");

            $objTable->index(["project_type_id", "stamp_deleted_at"], "idx_project-type-id_stamp-deleted-at");
            $objTable->index(["project_type_uuid", "stamp_deleted_at"], "idx_project-type-uuid_stamp-deleted-at");

            $objTable->dropUnique("uidx_data-id");
            $objTable->dropUnique("uidx_data-uuid");
            $objTable->dropUnique("uidx_data-format");
            $objTable->dropUnique("uidx_data-id_data-format");
            $objTable->dropUnique("uidx_data-uuid_data-format");
        });
        Schema::rename("soundblock_data_projects_formats", "soundblock_data_projects_types");
    }
}

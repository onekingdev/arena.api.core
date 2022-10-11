<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSoundblockDataProjectsRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_data_projects_roles", function (Blueprint $objTable){
            $objTable->renameColumn("row_id", "data_id");
            $objTable->renameIndex("idx_row-id_stamp-deleted-at", "idx_data-id_stamp-deleted-at");

            $objTable->renameColumn("row_uuid", "data_uuid");
            $objTable->renameIndex("idx_row-uuid_stamp-deleted-at", "idx_data-uuid_stamp-deleted-at");

            $objTable->renameColumn("project_role_name", "data_role");
            $objTable->renameIndex("idx_project-role-name_stamp-deleted-at", "idx_data-role_stamp-deleted-at");

            $objTable->unique("data_id", "uidx_data-id");
            $objTable->unique("data_uuid","uidx_data-uuid");
            $objTable->unique("data_role","uidx_data-role");
            $objTable->unique(["data_id", "data_role"],"uidx_data-id_data-role");
            $objTable->unique(["data_uuid", "data_role"],"uidx_data-uuid_data-role");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_data_projects_roles", function (Blueprint $objTable){
            $objTable->renameColumn("data_id", "row_id");
            $objTable->renameIndex("idx_data-id_stamp-deleted-at", "idx_row-id_stamp-deleted-at");

            $objTable->renameColumn("data_uuid", "row_uuid");
            $objTable->renameIndex("idx_data-uuid_stamp-deleted-at", "idx_row-uuid_stamp-deleted-at");

            $objTable->renameColumn("data_role", "project_role_name");
            $objTable->renameIndex("idx_data-role_stamp-deleted-at", "idx_project-role-name_stamp-deleted-at");

            $objTable->dropUnique("uidx_data-id");
            $objTable->dropUnique("uidx_data-uuid");
            $objTable->dropUnique("uidx_data-role");
            $objTable->dropUnique("uidx_data-id_data-role");
            $objTable->dropUnique("uidx_data-uuid_data-role");
        });
    }
}

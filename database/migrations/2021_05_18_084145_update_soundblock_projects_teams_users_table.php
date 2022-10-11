<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSoundblockProjectsTeamsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects_teams_users", function (Blueprint $objTable){
            $objTable->renameColumn("project_role_id", "role_id");
            $objTable->index("role_id", "idx_role-id");

            $objTable->renameColumn("project_role_uuid", "role_uuid");
            $objTable->index("role_uuid", "idx_role-uuid");

            $objTable->unique(["team_id", "user_id", "role_id"], "uidx_team-id_user-id_role-id");
            $objTable->unique(["team_uuid", "user_uuid", "role_uuid"], "uidx_team-uuid_user-uuid_role-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects_teams_users", function (Blueprint $objTable){
            $objTable->renameColumn("role_id", "project_role_id");
            $objTable->dropIndex("idx_role-id");

            $objTable->renameColumn("role_uuid", "project_role_uuid");
            $objTable->dropIndex("idx_role-uuid");

            $objTable->dropUnique("uidx_team-id_user-id_role-id");
            $objTable->dropUnique("uidx_team-uuid_user-uuid_role-uuid");
        });
    }
}

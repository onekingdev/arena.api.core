<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectRoleIdColumnsToSoundblockProjectsTeamsUsers extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("soundblock_projects_teams_users", function (Blueprint $table) {
            $table->unsignedBigInteger("project_role_id")->nullable()->after("user_role");
            $table->uuid("project_role_uuid")->nullable()->after("project_role_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("soundblock_projects_teams_users", function (Blueprint $table) {
            $table->dropColumn(["project_role_id", "project_role_uuid"]);
        });
    }
}

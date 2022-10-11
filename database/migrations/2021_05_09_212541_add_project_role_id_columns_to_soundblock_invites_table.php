<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectRoleIdColumnsToSoundblockInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_invites", function (Blueprint $table) {
            $table->unsignedBigInteger("project_role_id")->nullable()->after("invite_role");
            $table->uuid("project_role_uuid")->nullable()->after("project_role_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_invites", function (Blueprint $table) {
            $table->dropColumn(["project_role_id", "project_role_uuid"]);
        });
    }
}

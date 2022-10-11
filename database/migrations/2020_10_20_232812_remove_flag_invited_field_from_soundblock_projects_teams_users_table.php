<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFlagInvitedFieldFromSoundblockProjectsTeamsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects_teams_users", function (Blueprint $table) {
            $table->dropColumn("flag_invited");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects_teams_users", function (Blueprint $table) {
            $table->boolean("flag_invited")->default(false)->after("user_payout");
        });
    }
}

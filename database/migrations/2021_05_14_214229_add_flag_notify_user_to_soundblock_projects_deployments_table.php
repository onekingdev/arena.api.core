<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagNotifyUserToSoundblockProjectsDeploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects_deployments", function (Blueprint $objTable) {
            $objTable->boolean("flag_notify_user")->after("flag_notify")->default(0);
            $objTable->renameColumn("flag_notify", "flag_notify_admin");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects_deployments", function (Blueprint $objTable) {
            $objTable->renameColumn("flag_notify_admin", "flag_notify");
            $objTable->dropColumn("flag_notify_user");
        });
    }
}

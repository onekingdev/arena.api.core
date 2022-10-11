<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagNotifyColumnToSoundblockProjectsDeploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects_deployments", function (Blueprint $table) {
            $table->boolean("flag_notify")->default(false)->after("deployment_status");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects_deployments", function (Blueprint $table) {
            $table->dropColumn("flag_notify");
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDeploymentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects_deployments", function (Blueprint $objTable) {
            $objTable->string("deployment_status", 50)->change();
        });

        Schema::table("soundblock_projects_deployments_status", function (Blueprint $objTable) {
            $objTable->string("deployment_status", 50)->change();
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
            $objTable->string("deployment_status", 10)->change();
        });

        Schema::table("soundblock_projects_deployments_status", function (Blueprint $objTable) {
            $objTable->string("deployment_status", 10)->change();
        });
    }
}

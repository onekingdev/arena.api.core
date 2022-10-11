<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNamesInSoundblockDataPlansTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_data_plans_types", function (Blueprint $objTable) {
            $objTable->renameColumn("plan_additional_diskspace", "plan_diskspace_additional");
            $objTable->renameColumn("plan_additional_bandwidth", "plan_bandwidth_additional");
            $objTable->renameColumn("plan_additional_user", "plan_user_additional");

            $objTable->renameIndex("idx_plan-additional-bandwidth", "idx_plan-bandwidth-additional");
            $objTable->renameIndex("idx_plan-additional-users", "idx_plan-users-additional");
            $objTable->renameIndex("idx_plan-additional-diskspace", "idx_plan-diskspace-additional");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_data_plans_types", function (Blueprint $objTable) {
            $objTable->renameColumn("plan_diskspace_additional", "plan_additional_diskspace");
            $objTable->renameColumn("plan_bandwidth_additional", "plan_additional_bandwidth");
            $objTable->renameColumn("plan_user_additional", "plan_additional_user");

            $objTable->renameIndex("idx_plan-bandwidth-additional", "idx_plan-additional-bandwidth");
            $objTable->renameIndex("idx_plan-users-additional", "idx_plan-additional-users");
            $objTable->renameIndex("idx_plan-diskspace-additional", "idx_plan-additional-diskspace");
        });
    }
}

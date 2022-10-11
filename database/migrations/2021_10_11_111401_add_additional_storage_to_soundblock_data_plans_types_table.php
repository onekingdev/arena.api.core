<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalStorageToSoundblockDataPlansTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_data_plans_types", function (Blueprint $objTable) {
            $objTable->float("plan_additional_diskspace")->after("plan_diskspace")->index("idx_plan-additional-diskspace");
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
            $objTable->dropColumn("plan_additional_diskspace");
            $objTable->dropIndex("idx_plan-additional-diskspace");
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePlanDayColumnToServiceDateInSoundblockServicesPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_services_plans", function (Blueprint $table) {
            $table->date("service_date")->after("plan_day");
            $table->dropColumn("plan_day")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_services_plans", function (Blueprint $table) {
            $table->integer("service_date", false, true)->change();
            $table->renameColumn("service_date", "plan_day");
        });
    }
}

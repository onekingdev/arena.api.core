<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSoundblockServicesPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_services_plans", function (Blueprint $objTable){
            $objTable->float("plan_cost", 5, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_services_plans", function (Blueprint $objTable){
            $objTable->float("plan_cost", 4, 2)->change();
        });
    }
}

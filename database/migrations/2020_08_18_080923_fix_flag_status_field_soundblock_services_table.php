<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixFlagStatusFieldSoundblockServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_services", function (Blueprint $objTable) {
            $objTable->string("flag_status")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_services", function (Blueprint $objTable) {
            $objTable->string("flag_status", 10)->change();
        });
    }
}

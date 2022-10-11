<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlatformCategoryFieldToSoundblockDataPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_data_platforms", function (Blueprint $table) {
            $table->string("platform_category")->after("name")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_data_platforms", function (Blueprint $table) {
            $table->dropColumn("platform_category");
        });
    }
}

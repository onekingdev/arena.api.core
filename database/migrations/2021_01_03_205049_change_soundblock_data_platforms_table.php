<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSoundblockDataPlatformsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("soundblock_data_platforms", function (Blueprint $objTable) {
            $objTable->dropColumn("platform_category");

            $objTable->boolean("flag_music")->after("name");
            $objTable->boolean("flag_video")->after("flag_music");
            $objTable->boolean("flag_merchandising")->after("flag_video");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("soundblock_data_platforms", function (Blueprint $objTable) {
            $objTable->dropColumn("flag_music");
            $objTable->dropColumn("flag_video");
            $objTable->dropColumn("flag_merchandising");

            $objTable->string("platform_category")->nullable()->after("name");
        });
    }
}

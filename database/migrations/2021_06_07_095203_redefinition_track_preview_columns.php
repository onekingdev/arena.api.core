<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RedefinitionTrackPreviewColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn("soundblock_tracks", "preview_start") && Schema::hasColumn("soundblock_tracks", "track_preview_start"))
        {
            Schema::table("soundblock_tracks", function (Blueprint $objTable) {
                $objTable->dropColumn("preview_start");
                $objTable->dropColumn("preview_stop");
            });
            Schema::table("soundblock_tracks", function (Blueprint $objTable) {
                $objTable->renameColumn("track_preview_start", "preview_start");
                $objTable->renameColumn("track_preview_stop", "preview_stop");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn("soundblock_tracks", "preview_start") && !Schema::hasColumn("soundblock_tracks", "track_preview_start"))
        {
            Schema::table("soundblock_tracks", function (Blueprint $objTable) {
                $objTable->unsignedBigInteger("track_preview_start")->after("flag_allow_preorder_preview");
                $objTable->unsignedBigInteger("track_preview_stop")->after("track_preview_start");
            });
        }
    }
}

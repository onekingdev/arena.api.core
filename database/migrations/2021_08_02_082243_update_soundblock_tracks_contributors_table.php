<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSoundblockTracksContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_tracks_contributors", function (Blueprint $objTable) {
            $objTable->string("contributor_name")->after("contributor_uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_tracks_contributors", function (Blueprint $objTable) {
            $objTable->dropColumn("contributor_name");
        });
    }
}

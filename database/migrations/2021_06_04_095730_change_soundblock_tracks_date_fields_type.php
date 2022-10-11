<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSoundblockTracksDateFieldsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_tracks", function(blueprint $objTable){
            $objTable->dropColumn("track_release_date");
            $objTable->dropColumn("rights_contract");
        });
        Schema::table("soundblock_tracks", function(blueprint $objTable){
            $objTable->date("track_release_date")->after("track_volume_number")->index("idx_track-release-date");
            $objTable->date("rights_contract")->after("rights_owner")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `soundblock_tracks` CHANGE `track_release_date` `track_release_date` timestamp NOT NULL');
        DB::statement('ALTER TABLE `soundblock_tracks` CHANGE `rights_contract` `rights_contract` timestamp');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvatarColumnToSoundblockArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_artists", function (Blueprint $objTable) {
            $objTable->string("avatar_name")->nullable()->after("url_spotify")->index("idx_avatar-name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_artists", function (Blueprint $objTable) {
            $objTable->dropColumn("avatar_name");
            $objTable->dropIndex("idx_avatar-name");
        });
    }
}

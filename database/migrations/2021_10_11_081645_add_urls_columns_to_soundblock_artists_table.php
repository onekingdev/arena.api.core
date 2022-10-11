<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlsColumnsToSoundblockArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_artists", function (Blueprint $objTable) {
            $objTable->string("url_apple")->after("artist_name")->nullable();
            $objTable->string("url_soundcloud")->after("url_apple")->nullable();
            $objTable->string("url_spotify")->after("url_soundcloud")->nullable();

            $objTable->index("url_apple", "idx_url-apple");
            $objTable->index(["url_apple", "account_uuid"], "idx_url-apple_account-uuid");
            $objTable->index(["url_apple", "stamp_deleted_at"], "idx_url-apple_stamp-deleted-at");

            $objTable->index("url_spotify", "idx_url-spotify");
            $objTable->index(["url_spotify", "account_uuid"], "idx_url-spotify_account-uuid");
            $objTable->index(["url_spotify", "stamp_deleted_at"], "idx_url-spotify_stamp-deleted-at");

            $objTable->index("url_soundcloud", "idx_url-soundcloud");
            $objTable->index(["url_soundcloud", "account_uuid"], "idx_url-soundcloud_account-uuid");
            $objTable->index(["url_soundcloud", "stamp_deleted_at"], "idx_url-soundcloud_stamp-deleted-at");
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
            $objTable->dropColumn("url_apple");
            $objTable->dropColumn("url_soundcloud");
            $objTable->dropColumn("url_spotify");
            $objTable->dropIndex(["idx_url-apple", "idx_url-apple_account-uuid", "idx_url-apple_stamp-deleted-at"]);
            $objTable->dropIndex(["idx_url-soundcloud", "idx_url-soundcloud_account-uuid", "idx_url-soundcloud_stamp-deleted-at"]);
            $objTable->dropIndex(["idx_url-spotify", "idx_url-spotify_account-uuid", "idx_url-spotify_stamp-deleted-at"]);
        });
    }
}

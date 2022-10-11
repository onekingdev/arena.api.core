<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSoundblockFilesMusicAsSoundblockFilesTracks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("soundblock_files_music", "soundblock_files_tracks");

        Schema::table("soundblock_files_tracks", function (Blueprint $objTable){
            $objTable->renameColumn("row_id", "track_id");
            $objTable->renameColumn("row_uuid", "track_uuid");
            $objTable->renameColumn("file_track", "track_number");
            $objTable->renameColumn("file_duration", "track_duration");
            $objTable->renameColumn("file_isrc", "track_isrc");

            $objTable->string("track_artist", 255)->after("preview_stop")->index("idx_track-artist")->nullable();
            $objTable->string("track_version", 255)->after("track_artist")->nullable();

            $objTable->string("copyright_name", 255)->after("track_version");
            $objTable->string("copyright_year", 4)->after("copyright_name");

            $objTable->string("recording_location", 255)->after("copyright_year")->nullable();
            $objTable->string("recording_year", 4)->after("recording_location")->nullable();

            $objTable->unsignedBigInteger("track_language_id")->after("recording_year");
            $objTable->string("track_language_uuid")->after("track_language_id");
            $objTable->unsignedBigInteger("track_language_vocals_id")->after("track_language_uuid")->nullable();
            $objTable->string("track_language_vocals_uuid")->after("track_language_vocals_id")->nullable();

            $objTable->unsignedTinyInteger("track_volume_number")->after("track_language_vocals_uuid")->index("idx_track-volume-number");
            $objTable->timestamp("track_release_date")->after("track_volume_number")->index("idx_track-release-date");

            $objTable->string("country_recording", 255)->after("track_release_date")->nullable();
            $objTable->string("country_commissioning", 255)->after("country_recording")->nullable();

            $objTable->string("rights_holder", 255)->after("country_commissioning")->nullable();
            $objTable->string("rights_owner", 255)->after("rights_holder")->nullable();
            $objTable->timestamp("rights_contract")->after("rights_owner")->nullable();

            $objTable->longText("track_notes")->after("rights_contract")->nullable();
            $objTable->longText("track_lyrics")->after("track_notes")->nullable();

            $objTable->boolean("flag_track_explicit")->after("track_lyrics")->index("idx_flag-track-explicit");
            $objTable->boolean("flag_track_instrumental")->after("flag_track_explicit")->index("idx_flag-track-instrumental");
            $objTable->boolean("flag_allow_preorder")->after("flag_track_instrumental")->index("idx_flag-allow-preorder");
            $objTable->boolean("flag_allow_preorder_preview")->after("flag_allow_preorder")->index("idx_flag-allow-preorder-preview");

            $objTable->unsignedBigInteger("track_preview_start")->after("flag_allow_preorder_preview");
            $objTable->unsignedBigInteger("track_preview_stop")->after("track_preview_start");

            $objTable->index("track_number", "idx_track-number");

            $objTable->unique(["file_id", "track_number"], "uidx_file-id_track-number");
            $objTable->unique(["file_uuid", "track_number"], "uidx_file-uuid_track-number");

            $objTable->unique("track_isrc", "uidx_track-isrc");
            $objTable->unique(["file_id", "track_isrc"], "uidx_file-id_track-isrc");
            $objTable->unique(["file_uuid", "track_isrc"], "uidx_file-uuid_track-isrc");

            $objTable->renameIndex("uidx_row-id", "uidx_track-id");
            $objTable->renameIndex("uidx_row-uuid", "uidx_track-uuid");

            $objTable->renameIndex("stamp_created", "idx_stamp-created");
            $objTable->renameIndex("stamp_deleted", "idx_stamp-deleted");
            $objTable->renameIndex("stamp_updated", "idx_stamp-updated");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_files_tracks", function (Blueprint $objTable){
            $objTable->renameColumn("track_id", "row_id");
            $objTable->renameColumn("track_uuid", "row_uuid");
            $objTable->renameColumn("track_number", "file_track");
            $objTable->renameColumn("track_duration", "file_duration");
            $objTable->renameColumn("track_isrc", "file_isrc");

            $objTable->dropColumn("track_artist");
            $objTable->dropColumn("track_version");
            $objTable->dropColumn("copyright_name");
            $objTable->dropColumn("copyright_year");
            $objTable->dropColumn("recording_location");
            $objTable->dropColumn("recording_year");
            $objTable->dropColumn("track_language_id");
            $objTable->dropColumn("track_language_uuid");
            $objTable->dropColumn("track_language_vocals_id");
            $objTable->dropColumn("track_language_vocals_uuid");
            $objTable->dropColumn("track_volume_number");
            $objTable->dropColumn("track_release_date");
            $objTable->dropColumn("country_recording");
            $objTable->dropColumn("country_commissioning");
            $objTable->dropColumn("rights_holder");
            $objTable->dropColumn("rights_owner");
            $objTable->dropColumn("rights_contract");
            $objTable->dropColumn("track_notes");
            $objTable->dropColumn("track_lyrics");
            $objTable->dropColumn("flag_track_explicit");
            $objTable->dropColumn("flag_track_instrumental");
            $objTable->dropColumn("flag_allow_preorder");
            $objTable->dropColumn("flag_allow_preorder_preview");
            $objTable->dropColumn("track_preview_start");
            $objTable->dropColumn("track_preview_stop");

            $objTable->dropIndex("idx_track-number");
            $objTable->dropUnique("uidx_file-id_track-number");
            $objTable->dropUnique("uidx_file-uuid_track-number");
            $objTable->dropUnique("uidx_track-isrc");
            $objTable->dropUnique("uidx_file-id_track-isrc");
            $objTable->dropUnique("uidx_file-uuid_track-isrc");

            $objTable->renameIndex("uidx_track-id", "uidx_row-id");
            $objTable->renameIndex("uidx_track-uuid", "uidx_row-uuid");
            $objTable->renameIndex("idx_stamp-created", "stamp-created");
            $objTable->renameIndex("idx_stamp-deleted", "stamp-deleted");
            $objTable->renameIndex("idx-stamp_updated", "stamp-updated");
        });

        Schema::rename("soundblock_files_tracks", "soundblock_files_music");
    }
}

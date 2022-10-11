<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundblockTracksLyrics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_tracks_lyrics", function (Blueprint $objTable) {
            $objTable->bigIncrements("lyrics_id")->unique("uidx_lyrics-id");
            $objTable->uuid("lyrics_uuid")->unique("uidx_lyrics-uuid");

            $objTable->unsignedBigInteger("track_id")->index("idx_track-id");
            $objTable->uuid("track_uuid")->index("idx_track-uuid");

            $objTable->unsignedBigInteger("language_id")->index("idx_language-id");
            $objTable->uuid("language_uuid")->index("idx_language-uuid");

            $objTable->longText("track_lyrics");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique(["lyrics_id", "track_id"], "uidx_lyrics-id_track-id");
            $objTable->unique(["lyrics_uuid", "track_uuid"], "uidx_lyrics-uuid_track-uuid");
            $objTable->unique(["lyrics_id", "language_id"], "uidx_lyrics-id_language-id");
            $objTable->unique(["lyrics_uuid", "language_uuid"], "uidx_lyrics-uuid_language-uuid");
            $objTable->unique(["lyrics_id", "track_id", "language_id"], "uidx_lyrics-id_track-id_language-id");
            $objTable->unique(["lyrics_uuid", "track_uuid", "language_uuid"], "uidx_lyrics-uuid_track-uuid_language-uuid");
        });

        Schema::table("soundblock_tracks", function (Blueprint $objTable){
            $objTable->dropColumn("track_notes");
            $objTable->dropColumn("track_lyrics");
        });

        DB::statement('ALTER TABLE soundblock_tracks_lyrics ADD FULLTEXT INDEX `tidx_track-lyrice`(track_lyrics)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_tracks_lyrics");

        Schema::table("soundblock_tracks", function (Blueprint $objTable){
            $objTable->longText("track_notes")->after("rights_contract")->nullable();
            $objTable->longText("track_lyrics")->after("track_notes")->nullable();
        });
    }
}

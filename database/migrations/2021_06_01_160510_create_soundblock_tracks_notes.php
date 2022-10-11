<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundblockTracksNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_tracks_notes", function (Blueprint $objTable) {
            $objTable->bigIncrements("note_id")->unique("uidx_note-id");
            $objTable->uuid("note_uuid")->unique("uidx_note-uuid");

            $objTable->unsignedBigInteger("track_id")->index("idx_track-id");
            $objTable->uuid("track_uuid")->index("idx_track-uuid");

            $objTable->unsignedBigInteger("language_id")->index("idx_language-id");
            $objTable->uuid("language_uuid")->index("idx_language-uuid");

            $objTable->longText("track_note");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique(["note_id", "track_id"], "uidx_note-id_track-id");
            $objTable->unique(["note_uuid", "track_uuid"], "uidx_note-uuid_track-uuid");
            $objTable->unique(["note_id", "language_id"], "uidx_note-id_language-id");
            $objTable->unique(["note_uuid", "language_uuid"], "uidx_note-uuid_language-uuid");
            $objTable->unique(["note_id", "track_id", "language_id"], "uidx_note-id_track-id_language-id");
            $objTable->unique(["note_uuid", "track_uuid", "language_uuid"], "uidx_note-uuid_track-uuid_language-uuid");
        });

        DB::statement('ALTER TABLE soundblock_tracks_notes ADD FULLTEXT INDEX `tidx_track-note`(track_note)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_tracks_notes");
    }
}

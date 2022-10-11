<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundblockTracksContributors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_tracks_contributors", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid");

            $objTable->unsignedBigInteger("file_id")->index("idx_file-id");
            $objTable->uuid("file_uuid")->index("idx_file-uuid");

            $objTable->unsignedBigInteger("track_id")->index("idx_track-id");
            $objTable->uuid("track_uuid")->index("idx_track-uuid");

            $objTable->unsignedBigInteger("contributor_id")->index("idx_contributor-id");
            $objTable->uuid("contributor_uuid")->index("idx_contributor-uuid");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique(["file_id", "contributor_id"], "uidx_file-id_contributor-id");
            $objTable->unique(["file_uuid", "contributor_uuid"], "uidx_file-uuid_contributor-uuid");
            $objTable->unique(["track_id", "contributor_id"], "uidx_track-id_contributor-id");
            $objTable->unique(["track_uuid", "contributor_uuid"], "uidx_track-uuid_contributor-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_tracks_contributors");
    }
}

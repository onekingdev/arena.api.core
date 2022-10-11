<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundblockTracksPublishers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_tracks_publishers", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid");

            $objTable->unsignedBigInteger("file_id")->index("idx_file-id");
            $objTable->uuid("file_uuid")->index("idx_file-uuid");

            $objTable->unsignedBigInteger("track_id")->index("idx_track-id");
            $objTable->uuid("track_uuid")->index("idx_track-uuid");

            $objTable->unsignedBigInteger("publisher_id")->index("idx_publisher-id");
            $objTable->uuid("publisher_uuid")->index("idx_publisher-uuid");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique(["file_id", "publisher_id"], "uidx_file-id_publisher-id");
            $objTable->unique(["file_uuid", "publisher_uuid"], "uidx_file-uuid_publisher-uuid");
            $objTable->unique(["track_id", "publisher_id"], "uidx_track-id_publisher-id");
            $objTable->unique(["track_uuid", "publisher_uuid"], "uidx_track-uuid_publisher-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_tracks_publishers");
    }
}

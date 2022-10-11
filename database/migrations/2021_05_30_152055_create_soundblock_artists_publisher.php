<?php

use App\Models\BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoundblockArtistsPublisher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_artists_publisher", function (Blueprint $objTable) {
            $objTable->bigIncrements("publisher_id");
            $objTable->uuid("publisher_uuid");

            $objTable->unsignedBigInteger("service_id")->index("idx_service-id");
            $objTable->uuid("service_uuid")->index("idx_service-uuid");

            $objTable->unsignedBigInteger("artist_id")->index("idx_artist-id");
            $objTable->uuid("artist_uuid")->index("idx_artist-uuid");

            $objTable->string("publisher_name")->index("idx_publisher-name");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("publisher_id", "uidx_publisher-id");
            $objTable->unique("publisher_uuid", "uidx_publisher-uuid");
            $objTable->unique(["artist_id", "publisher_name"], "uidx_artist-id_publisher-name");
            $objTable->unique(["artist_uuid", "publisher_name"], "uidx_artist-uuid_publisher-name");
            $objTable->unique(["service_id", "artist_id", "publisher_name"], "uidx_service-id_artist-id_publisher-name");
            $objTable->unique(["service_uuid", "artist_uuid", "publisher_name"], "uidx_service-uuid_artist-uuid_publisher-name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_artists_publisher");
    }
}

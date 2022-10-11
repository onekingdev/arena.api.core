<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockCollectionsDirectories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("soundblock_collections_directories", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("row_uuid");
            $objTable->unsignedBigInteger("collection_id")->index("collection_id");
            $objTable->uuid("collection_uuid")->index("collection_uuid");
            $objTable->unsignedBigInteger("directory_id")->index("directory_id");
            $objTable->uuid("directory_uuid")->index("directory_uuid");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->index("row_id", "uidx_row-id");
            $objTable->unique(["collection_id", "directory_id"], "uidx_collection-id_directory-id");
            $objTable->unique(["directory_id", "collection_id"], "uidx_directory-id_collection-id");
            $objTable->unique(["collection_uuid", "directory_uuid"], "uidx_collection-uuid_directory-uuid");
            $objTable->unique(["directory_uuid", "collection_uuid"], "uidx_directory-uuid_collection-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("soundblock_collections_directories");
    }
}

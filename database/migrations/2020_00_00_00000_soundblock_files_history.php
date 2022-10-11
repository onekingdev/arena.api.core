<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockFilesHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("soundblock_files_history", function(Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");
            $objTable->unsignedBigInteger("parent_id")->index("idx_parent-id")->nullable();
            $objTable->uuid("parent_uuid")->index("idx_parent-uuid")->nullable();
            $objTable->unsignedBigInteger("collection_id")->index("idx_collection-id")->nullable();
            $objTable->uuid("collection_uuid")->index("idx_collection-uuid")->nullable();
            $objTable->unsignedBigInteger("file_id")->index("idx_file-id");
            $objTable->uuid("file_uuid")->index("idx_file-uuid");
            $objTable->string("file_action", 25);
            $objTable->string("file_category", 5);
            $objTable->string("file_memo", 175)->nullable();

            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("row_id", "uidx_row-id");
            $objTable->unique(["collection_id", "file_id"], "uidx_collection-id_file-id");
            $objTable->unique(["file_id", "collection_id"], "uidx_file-id_collection-id");
            $objTable->unique(["collection_uuid", "file_uuid"], "uidx_collection-uuid_file-uuid");
            $objTable->unique(["file_uuid", "collection_uuid"], "uidx_file-uuid_collection-uuid");
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
        Schema::dropIfExists("soundblock_files_history");
    }
}

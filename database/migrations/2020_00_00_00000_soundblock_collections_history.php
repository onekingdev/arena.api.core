<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockCollectionsHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_collections_history", function (Blueprint $objTable) {
            $objTable->bigIncrements("history_id");
            $objTable->uuid("history_uuid")->unique("uidx_history-uuid");
            $objTable->unsignedBigInteger("collection_id")->unique("uidx_collection-id");
            $objTable->uuid("collection_uuid")->unique("uidx_collection-uuid");
            $objTable->string("history_category", 10);
            $objTable->unsignedBigInteger("history_size");
            $objTable->string("file_action", 10);
            $objTable->string("history_comment", 250)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unique("history_id", "uidx_history-id");
            $objTable->unique(["history_id", "collection_id"], "uidx_history-id_collection-id");
            $objTable->unique(["collection_id", "history_id"], "uidx_collection-id_history-id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_collections_history");
    }
}

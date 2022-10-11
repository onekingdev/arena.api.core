<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("core_card_items", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id")->index("idx_row-id")->unique("uidx_row-id");
            $objTable->uuid("row_uuid")->index("idx_row-uuid")->unique("uidx_row-uuid");

            $objTable->unsignedBigInteger("card_id")->index("idx_card-id");
            $objTable->uuid("card_uuid")->index("idx_card-uuid");

            $objTable->unsignedBigInteger("model_id")->index("idx_model-id");
            $objTable->uuid("model_uuid")->index("idx_model-uuid");
            $objTable->string("model_class")->index("idx_model-type");

            $objTable->integer("quantity");

            $objTable->index(["row_id", "model_id"], "idx_row-id_model-id");
            $objTable->index(["row_uuid", "model_uuid"], "idx_row-uuid_model-uuid");
            $objTable->index(["row_id", "card_id"], "idx_row-id_card-id");
            $objTable->index(["row_uuid", "card_uuid"], "idx_row-uuid_card-uuid");
            $objTable->index(["row_id", "stamp_deleted_at"], "idx_row-id_stamp-deleted-at");
            $objTable->index(["row_uuid", "stamp_deleted_at"], "idx_row-uuid_stamp-deleted-at");
            $objTable->index(["card_id", "stamp_deleted_at"], "idx_card-id_stamp-deleted-at");
            $objTable->index(["card_uuid", "stamp_deleted_at"], "idx_card-uuid_stamp-deleted-at");
            $objTable->index(["model_id", "stamp_deleted_at"], "idx_model-id_stamp-deleted-at");
            $objTable->index(["model_uuid", "stamp_deleted_at"], "idx_model-uuid_stamp-deleted-at");
            $objTable->index(["row_id", "model_id", "stamp_deleted_at"], "idx_row-id_model-id_stamp-deleted-at");
            $objTable->index(["row_uuid", "model_uuid", "stamp_deleted_at"], "idx_row-uuid_model-uuid_stamp-deleted-at");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("core_card_items");
    }
}

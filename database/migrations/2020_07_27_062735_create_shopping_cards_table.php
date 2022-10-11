<?php

use App\Models\BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("core_shopping_cards", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id")->index("idx_row-id")->unique("uidx_row-id");
            $objTable->uuid("row_uuid")->index("idx_row-uuid")->unique("uidx_row-uuid");

            $objTable->unsignedBigInteger("user_id")->nullable()->index("idx_user-id");
            $objTable->uuid("user_uuid")->nullable()->index("idx_user-uuid");
            $objTable->string("user_ip")->nullable()->index("idx_user-ip");

            $objTable->boolean("flag_active")->default(true);

            $objTable->index(["row_id", "user_id"], "idx_row-id_user-id");
            $objTable->index(["row_uuid", "user_uuid"], "idx_row-uuid_user-uuid");
            $objTable->index(["row_id", "stamp_deleted_at"], "idx_row-id_stamp-deleted-at");
            $objTable->index(["row_uuid", "stamp_deleted_at"], "idx_row-uuid_stamp-deleted-at");
            $objTable->index(["user_id", "stamp_deleted_at"], "idx_user-id_stamp-deleted-at");
            $objTable->index(["user_uuid", "stamp_deleted_at"], "idx_user-uuid_stamp-deleted-at");
            $objTable->index(["row_id", "user_id", "stamp_deleted_at"], "idx_row-id_user-id_stamp-deleted-at");
            $objTable->index(["row_uuid", "user_uuid", "stamp_deleted_at"], "idx_row-uuid_user-uuid_stamp-deleted-at");

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
        Schema::dropIfExists("core_shopping_cards");
    }
}

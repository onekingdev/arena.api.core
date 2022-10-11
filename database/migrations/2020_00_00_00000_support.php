<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\BaseModel;

class Support extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("support", function (Blueprint $objTable) {
            $objTable->bigIncrements("support_id");
            $objTable->uuid("support_uuid")->unique("support_uuid");
            $objTable->unsignedBigInteger("parent_id")->index("idx_parent-id")->nullable();
            $objTable->uuid("parent_uuid")->index("idx_parent-uuid")->nullable();
            $objTable->unsignedBigInteger("app_id")->index("idx_app-id");
            $objTable->uuid("app_uuid")->index("idx_app-uuid");
            $objTable->string("support_category", 25);
            $objTable->string("support_memo", 200)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("support_id", "uidx_support-id");

            $objTable->index(["support_id", "app_id"], "idx_support-id_app-id");
            $objTable->index(["app_id", "support_id"], "idx_app-id_support-id");
            $objTable->index(["support_uuid", "app_uuid"], "idx_support-uuid_app-uuid");
            $objTable->index(["app_uuid", "support_uuid"], "idx_app-uuid_support-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("support");
    }
}

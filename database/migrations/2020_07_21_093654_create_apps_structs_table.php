<?php

use App\Models\BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsStructsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("core_apps_struct", function (Blueprint $objTable) {
            $objTable->bigIncrements("struct_id")->index("idx_struct-id")->unique("uidx_struct-id");
            $objTable->uuid("struct_uuid")->index("idx_struct-uuid")->unique("uidx_struct-uuid");

            $objTable->unsignedBigInteger("app_id")->index("idx_app-id");
            $objTable->uuid("app_uuid")->index("idx_app-uuid");

            $objTable->unsignedBigInteger("parent_id")->index("idx_parent-id");
            $objTable->uuid("parent_uuid")->index("idx_parent-uuid");

            $objTable->string("struct_prefix")->index("idx_struct-prefix")->unique("uidx_struct-prefix");
            $objTable->json("struct_json");

            $objTable->index(["struct_id", "stamp_deleted_at"], "idx_struct-id_stamp-deleted-at");
            $objTable->index(["struct_uuid", "stamp_deleted_at"], "idx_struct-uuid_stamp-deleted-at");
            $objTable->index(["app_id", "stamp_deleted_at"], "idx_app-id_stamp-deleted-at");
            $objTable->index(["app_uuid", "stamp_deleted_at"], "idx_app-uuid_stamp-deleted-at");
            $objTable->index(["parent_id", "stamp_deleted_at"], "idx_parent-id_stamp-deleted-at");
            $objTable->index(["parent_uuid", "stamp_deleted_at"], "idx_parent-uuid_stamp-deleted-at");
            $objTable->index(["struct_prefix", "stamp_deleted_at"], "idx_struct-prefix_stamp-deleted-at");

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
        Schema::dropIfExists("core_apps_struct");
    }
}

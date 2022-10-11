<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class AuthPermissionsGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("auth_permissions_groups", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");
            $objTable->unsignedBigInteger("group_id")->index("idx_group-id");
            $objTable->uuid("group_uuid")->index("idx_group-uuid");
            $objTable->unsignedBigInteger("permission_id")->index("idx_permission-id");
            $objTable->uuid("permission_uuid")->index("idx_permission-uuid");
            $objTable->boolean("permission_value");

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
            $objTable->unique(["group_id", "permission_id"], "uidx_group-id_permission-id");
            $objTable->unique(["group_uuid", "permission_uuid"], "uidx_group-uuid_permission-uuid");
            $objTable->unique(["permission_id", "group_id"], "uidx_permission-id_group-id");
            $objTable->unique(["permission_uuid", "group_uuid"], "uidx_permission-uuid_group-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("auth_permissions_groups");
    }
}

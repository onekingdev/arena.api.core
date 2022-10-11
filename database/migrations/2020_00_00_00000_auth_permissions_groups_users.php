<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class AuthPermissionsGroupsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("auth_permissions_groups_users");
        Schema::create("auth_permissions_groups_users", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");
            $objTable->unsignedBigInteger("group_id")->index("idx_group-id");
            $objTable->uuid("group_uuid")->index("idx_group-uuid");
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id");
            $objTable->uuid("user_uuid")->index("idx_user-uuid");
            $objTable->unsignedBigInteger("permission_id")->index("idx_permission-id");
            $objTable->uuid("permission_uuid")->index("idx_permission-uuid");
            $objTable->boolean("permission_value");

            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::IDX_STAMP_UPDATED);
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::IDX_STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("row_id", "uidx_row-id");
            $objTable->unique(["group_id", "user_id", "permission_id"], "uidx_group-id_user-id_permission-id");
            $objTable->unique(["group_id", "permission_id", "user_id"], "uidx_group-id_permission-id_user-id");
            $objTable->unique(["user_id", "group_id", "permission_id"], "uidx_user-id_group-id_permission-id");
            $objTable->unique(["user_id", "permission_id", "group_id"], "uidx_user-id_permission-id_group-id");
            $objTable->unique(["permission_id", "user_id", "group_id"], "uidx_permission-id_user-id_group-id");
            $objTable->unique(["permission_id", "group_id", "user_id"], "uidx_permission-id_group-id_user-id");

            $objTable->unique(["group_uuid", "user_uuid", "permission_uuid"], "uidx_group-uuid_user-uuid_permission-uuid");
            $objTable->unique(["group_uuid", "permission_uuid", "user_uuid"], "uidx_group-uuid_permission-uuid_user-uuid");
            $objTable->unique(["user_uuid", "permission_uuid", "group_uuid"], "uidx_user-uuid_permission-uuid_group-uuid");
            $objTable->unique(["user_uuid", "group_uuid", "permission_uuid"], "uidx_user-uuid_group-uuid_permission-uuid");
            $objTable->unique(["permission_uuid", "user_uuid", "group_uuid"], "uidx_permission-uuid_user-uuid_group-uuid");
            $objTable->unique(["permission_uuid", "group_uuid", "user_uuid"], "uidx_permission-uuid_group-uuid_user-uuid");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("auth_permissions_groups_users");
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class AuthGroupsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("auth_groups_users");
        Schema::create("auth_groups_users", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");
            $objTable->unsignedBigInteger("group_id")->index("idx_group-id");
            $objTable->uuid("group_uuid")->index("group_uuid");
            $objTable->unsignedBigInteger("app_id")->index("idx_app-id");
            $objTable->uuid("app_uuid")->index("idx_app-uuid");
            $objTable->unsignedBigInteger("user_id")->index("user_id");
            $objTable->uuid("user_uuid")->index("user_uuid");

            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::IDX_STAMP_CREATED);
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::IDX_STAMP_UPDATED);
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::IDX_STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("row_id", "uidx_row-id");
            $objTable->unique(["group_id", "user_id"], "uidx_group-id_user-id");
            $objTable->unique(["group_uuid", "user_uuid"], "uidx_group-uuid_user-uuid");
            $objTable->unique(["user_id", "group_id"], "uidx_user-id_group-id");
            $objTable->unique(["user_uuid", "group_uuid"], "uidx_user-uuid_group-uuid");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("auth_groups_users");
    }
}

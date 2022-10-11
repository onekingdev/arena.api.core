<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class AuthGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("auth_groups", function (Blueprint $objTable) {
            $objTable->bigIncrements("group_id");
            $objTable->uuid("group_uuid")->unique("uidx_group-uuid");
            $objTable->unsignedBigInteger("auth_id");
            $objTable->uuid("auth_uuid");
            $objTable->string("group_name", 175)->unique();
            $objTable->string("group_memo", 175)->nullable();
            $objTable->boolean("flag_critical")->default(true)->index("idx_flag-critical");

            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::IDX_STAMP_CREATED);
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::IDX_STAMP_UPDATED);
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::IDX_STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("group_id", "uidx_group-id");
            $objTable->unique(["auth_id", "group_id"], "uidx_auth-id_group-id");
            $objTable->unique(["auth_uuid", "group_uuid"], "uidx_auth-uuid_group-uuid");
            $objTable->unique(["group_id", "auth_id", "group_name"], "uidx_group-id_auth-id_group-name");
            $objTable->unique(["group_uuid", "auth_uuid", "group_name"], "uidx_group-uuid_auth-uuid_group-name");
            $objTable->unique(["auth_id", "group_id", "group_name"], "uidx_auth-id_group-id_group-name");
            $objTable->unique(["auth_uuid", "group_uuid", "group_name"], "uidx_auth-uuid_group-uuid_group-name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("auth_groups");
    }
}

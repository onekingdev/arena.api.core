<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class AuthPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("auth_permissions");
        Schema::create("auth_permissions", function (Blueprint $objTable) {
            $objTable->bigIncrements("permission_id");
            $objTable->uuid("permission_uuid")->unique("uidx_permission-uuid");
            $objTable->unsignedBigInteger("auth_id");
            $objTable->uuid("auth_uuid");
            $objTable->string("permission_name", 175)->unique("permission_name");
            $objTable->string("permission_memo", 175);
            $objTable->boolean("flag_critical")->index("idx_flag-critical")->default(true);

            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("permission_id", "uidx_permission-id");
            $objTable->unique(["permission_id", "permission_name"], "uidx_permission-id_permission-name");
            $objTable->unique(["permission_uuid", "permission_name"], "uidx_permission-uuid_permission-name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("auth_permissions");
    }
}

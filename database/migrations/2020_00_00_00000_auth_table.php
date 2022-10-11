<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class AuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("auth");
        Schema::create("auth", function (Blueprint $objTable) {
            $objTable->bigIncrements("auth_id");
            $objTable->uuid("auth_uuid")->unique("uidx_auth-uuid");
            $objTable->string("auth_name", 25)->unique("uidx_auth-name");
            $objTable->unsignedBigInteger("app_id")->index("idx_app-id");
            $objTable->uuid("app_uuid")->index("idx_app-uuid");

            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::IDX_STAMP_CREATED);
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::IDX_STAMP_UPDATED);
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::IDX_STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("auth_id", "uidx_auth-id");
            $objTable->unique(["auth_id", "auth_name"], "uidx_auth-id_auth-name");
            $objTable->unique(["auth_uuid", "auth_name"], "uidx_auth-uuid_auth-name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("auth");
    }
}

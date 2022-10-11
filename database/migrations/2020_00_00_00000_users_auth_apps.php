<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersAuthApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users_auth_apps", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id");
            $objTable->uuid("user_uuid")->index("idx_user-uuid");
            $objTable->unsignedBigInteger("app_id")->index("idx_app-id");
            $objTable->uuid("app_uuid")->index("idx_app-uuid");

            $objTable->unsignedBigInteger(BaseModel::STAMP_VISITED)->index(BaseModel::IDX_STAMP_VISITED);
            $objTable->timestamp(BaseModel::VISITED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_VISITED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_EXITED)->index(BaseModel::IDX_STAMP_EXITED)->nullable();
            $objTable->timestamp(BaseModel::EXITED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_EXITED_BY)->nullable();

            $objTable->index(["user_id", "app_id"], "idx_user-id_app-id");
            $objTable->index(["app_id", "user_id"], "idx_app-id_user-id");
            $objTable->index(["user_uuid", "app_uuid"], "idx_user-uuid_app-uuid");
            $objTable->index(["app_uuid", "user_uuid"], "idx_app-uuid_user-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("users_auth_apps");
    }
}

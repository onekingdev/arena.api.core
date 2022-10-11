<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class NotificationsUsersSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("notifications_users_settings", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");

            $objTable->unsignedBigInteger("user_id");
            $objTable->uuid("user_uuid");

            $objTable->unsignedBigInteger("app_id");
            $objTable->uuid("app_uuid");

            $objTable->json("user_setting")->nullable();

            $objTable->boolean("flag_apparel")->default(false);
            $objTable->boolean("flag_arena")->default(false);
            $objTable->boolean("flag_catalog")->default(false);
            $objTable->boolean("flag_io")->default(false);
            $objTable->boolean("flag_merchandising")->default(false);
            $objTable->boolean("flag_music")->default(false);
            $objTable->boolean("flag_office")->default(false);
            $objTable->boolean("flag_soundblock")->default(false);
            $objTable->boolean("flag_account")->default(false);
//
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

            $objTable->unique(["user_id", "app_id"], "uidx_user-id_app-id");
            $objTable->unique(["app_id", "user_id"], "uidx_app-id_user-id");

            $objTable->unique(["user_uuid", "app_uuid"], "uidx_user-uuid_app-uuid");
            $objTable->unique(["app_uuid", "user_uuid"], "uidx_app-uuid_user-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("notifications_users_settings");
    }
}

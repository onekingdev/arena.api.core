<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class NotificationsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("notifications_users", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");
            $objTable->unsignedBigInteger("notification_id")->index("idx_notification-id");
            $objTable->uuid("notification_uuid")->index("idx_notification-uuid");
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id");
            $objTable->uuid("user_uuid")->index("idx_user-uuid");
            $objTable->string("notification_state", 10)->default("unread");//read, unread, archieved, deleted
            $objTable->boolean("flag_canarchive")->index("idx_flag-canarchive")->default(true);
            $objTable->boolean("flag_candelete")->index("idx_flag-candelete")->default(true);
            $objTable->boolean("flag_email")->index("idx_flag-email")->default(false);

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
            $objTable->unique(["notification_id", "user_id"], "uidx_notification-id_user-id");
            $objTable->unique(["user_id", "notification_id"], "uidx_user-id_notification-id");
            $objTable->unique(["notification_uuid", "user_uuid"], "uidx_notification-uuid_user-uuid");
            $objTable->unique(["user_uuid", "notification_uuid"], "uidx_user-uuid_notification-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("notifications_users");
    }
}

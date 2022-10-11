<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("support_tickets_users");
        Schema::create("support_tickets_users", function (Blueprint $table) {
            $table->bigIncrements("row_id")->index("idx_row-id");
            $table->uuid("row_uuid")->index("idx_row-uuid");
            $table->integer("user_id");
            $table->uuid("user_uuid");
            $table->integer("ticket_id");
            $table->uuid("ticket_uuid");

            $table->boolean("flag_office")->default(false);
            $table->boolean("flag_active")->default(true);

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unique("row_id", "uidx_row-id");
            $table->unique("row_uuid", "uidx_row-uuid");

            $table->unique(["user_id", "ticket_id"], "uidx_user-id_ticket-id");
            $table->unique(["user_uuid", "ticket_uuid"], "uidx_user-uuid_ticket-uuid");
            $table->unique(["ticket_id", "user_id"], "uidx_ticket-id_user-id");
            $table->unique(["ticket_uuid", "user_uuid"], "uidx_ticket-uuid_user-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("support_tickets_users");
    }
}

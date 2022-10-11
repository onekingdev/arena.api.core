<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SupportTicketsMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("support_tickets_messages");
        Schema::create("support_tickets_messages", function (Blueprint $objTable) {
            $objTable->bigIncrements("message_id");
            $objTable->uuid("message_uuid")->unique("message_uuid", "uidx_message-uuid");
            $objTable->unsignedBigInteger("ticket_id")->index("idx_ticket-id");
            $objTable->uuid("ticket_uuid")->index("idx_ticket-uuid");
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id");
            $objTable->uuid("user_uuid")->index("idx_user-uuid");
            $objTable->text("message_text");
            $objTable->boolean("flag_attachments")->default(false)->index("idx_flag-attachments");
            $objTable->boolean("flag_notified")->default(false)->index("idx_flag-notified");
            $objTable->boolean("flag_office")->default(false)->index("idx_flag-office");
            $objTable->boolean("flag_officeonly")->default(false)->index("idx_flag-officeonly");
            $objTable->string("flag_status", 6)->default("Unread")->index("idx_flag-status");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("message_id", "uidx_message-id");

            $objTable->index(["message_id", "ticket_id"], "idx_message-id_ticket-id");
            $objTable->index(["ticket_id", "message_id"], "idx_ticket-id_message-id");
            $objTable->index(["message_uuid", "ticket_uuid"], "idx_message-uuid_ticket-uuid");
            $objTable->index(["ticket_uuid", "message_uuid"], "idx_ticket-uuid_message-uuid");

            $objTable->index(["message_id", "user_id"], "idx_message-id_user-id");
            $objTable->index(["user_id", "message_id"], "idx_user-id_message-id");
            $objTable->index(["user_uuid", "message_uuid"], "idx_user-uuid_message-uuid");
            $objTable->index(["message_uuid", "user_uuid"], "idx_message-uuid_user-uuid");

            $objTable->index(["user_id", "ticket_id"], "idx_user-id_ticket-id");
            $objTable->index(["ticket_id", "user_id"], "idx_ticket-id_user-id");
            $objTable->index(["user_uuid", "ticket_uuid"], "idx_user-uuid_ticket-uuid");
            $objTable->index(["ticket_uuid", "user_uuid"], "idx_ticket-uuid_user-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("support_tickets_messages");
    }
}

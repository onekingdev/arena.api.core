<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SupportTicketsAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("support_tickets_attachments");
        Schema::create("support_tickets_attachments", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");
            $objTable->unsignedBigInteger("ticket_id")->index("idx_ticket-id");
            $objTable->uuid("ticket_uuid")->index("idx_ticket-uuid");
            $objTable->unsignedBigInteger("message_id")->index("idx_message-id");
            $objTable->uuid("message_uuid")->index("idx_message-uuid");
            $objTable->string("attachment_name", 200)->nullable();
            $objTable->string("attachment_url", 500);

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("row_id", "uidx_row-id");

            $objTable->index(["ticket_id", "message_id"], "idx_ticket-id_message-id");
            $objTable->index(["message_id", "ticket_id"], "idx_message-id_ticket-id");

            $objTable->index(["ticket_uuid", "message_uuid"], "idx_ticket-uuid_message-uuid");
            $objTable->index(["message_uuid", "ticket_uuid"], "idx_message-uuid_ticket-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("support_tickets_attachments");
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SupportTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("support_tickets", function (Blueprint $objTable) {
            $objTable->bigIncrements("ticket_id");
            $objTable->uuid("ticket_uuid")->unique("uidx_ticket-uuid");
            $objTable->unsignedBigInteger("support_id")->index("idx_support-id");
            $objTable->uuid("support_uuid")->index("idx_support-uuid");
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id");
            $objTable->uuid("user_uuid")->index("idx_user-uuid");
            $objTable->string("ticket_title", 175);
            $objTable->string("flag_status", 20)->default("Unread");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("ticket_id", "uidx_ticket-id");
            $objTable->index(["ticket_id", "support_id"], "idx_ticket-id_suppot-id");
            $objTable->index(["support_id", "ticket_id"], "idx_support-id_ticket-id");
            $objTable->index(["ticket_uuid", "support_uuid"], "idx_ticket-uuid_suppot-uuid");
            $objTable->index(["support_uuid", "ticket_uuid"], "idx_support-uuid_ticket-uuid");

            $objTable->index(["ticket_id", "user_id"], "idx_ticket-id_user-id");
            $objTable->index(["user_id", "ticket_id"], "idx_user-id_ticket-id");
            $objTable->index(["ticket_uuid", "user_uuid"], "idx_ticket-uuid_user-uuid");
            $objTable->index(["user_uuid", "ticket_uuid"], "idx_user-uuid_ticket-uuid");

            $objTable->index(["user_id", "support_id"], "idx_user-id_support-id");
            $objTable->index(["support_id", "user_id"], "idx_support-id_user-id");
            $objTable->index(["user_uuid", "support_uuid"], "idx_user-uuid_support-uuid");
            $objTable->index(["support_uuid", "user_uuid"], "idx_support-uuid_user-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("support_tickets");
    }
}

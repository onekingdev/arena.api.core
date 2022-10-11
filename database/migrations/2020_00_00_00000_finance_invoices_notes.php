<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class FinanceInvoicesNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("finance_invoices_notes", function (Blueprint $table) {
            $table->bigIncrements("row_id");
            $table->uuid("row_uuid")->unique("uidx_row-uuid");
            $table->unsignedBigInteger("invoice_id")->index("idx_invoice_id");
            $table->uuid("invoice_uuid")->index("idx_invoice-uuid");
            $table->unsignedBigInteger("user_id")->index("idx_user-id");
            $table->uuid("user_uuid")->index("idx_user-uuid");
            $table->text("note_text");

            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unique("row_id", "uidx_row-id");
            $table->index(["invoice_id", "user_id"], "idx_invoice-id_user-id");
            $table->index(["invoice_uuid", "user_uuid"], "idx_invoice-uuid_user-uuid");
            $table->index(["user_id", "invoice_id"], "idx_user-id_invoice-id");
            $table->index(["user_uuid", "invoice_uuid"], "idx_user-uuid_invoice-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("finance_invoices_notes");
    }
}
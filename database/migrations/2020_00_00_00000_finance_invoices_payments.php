<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class FinanceInvoicesPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("finance_invoices_payments", function (Blueprint $table) {
            $table->bigIncrements("row_id");
            $table->uuid("row_uuid")->unique("uidx_row-uuid");
            $table->unsignedBigInteger("invoice_id")->unique("uidx_invoice-id");
            $table->uuid("invoice_uuid")->unique("uidx_invoice-uuid");
            $table->unsignedBigInteger("payment_id")->index("idx_payment-id");
            $table->uuid("payment_uuid")->index("idx_payment-uuid");
            $table->json("payment_response");
            $table->string("payment_status", 10)->index("idx_payment-status");

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
            $table->unique(["invoice_id", "payment_id"], "uidx_invoice-id_payment-id");
            $table->unique(["invoice_uuid", "payment_uuid"], "uidx_invoice-uuid_payment-uuid");
            $table->unique(["payment_id", "invoice_id"], "uidx_payment-id_invoice-id");
            $table->unique(["payment_uuid", "invoice_uuid"], "uidx_payment-uuid_invoice-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_invoices_payments');
    }
}
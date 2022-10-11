<?php

use App\Models\BaseModel;
use App\Models\Accounting\AccountingInvoiceTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FinanceInvoicesTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_invoices_transactions', function (Blueprint $table) {
            $table->bigIncrements("transaction_id");
            $table->uuid("transaction_uuid")->unique("uidx_transaction-uuid");
            $table->unsignedBigInteger("invoice_id")->index("idx_invoice-id");
            $table->uuid("invoice_uuid")->index("idx_invoice-uuid");
            $table->string("app_table", 175);
            $table->string("app_field", 175);
            $table->unsignedBigInteger("app_field_id");
            $table->unsignedBigInteger("transaction_cost");
            $table->unsignedBigInteger("transaction_quantity");
            $table->unsignedBigInteger("transaction_cost_total");
            $table->string("transaction_name", 175);
            $table->string("transaction_memo", 200)->nullable();
            $table->string("transaction_status", 25);
            $table->integer("transaction_discount")->default(0);
            $table->unsignedBigInteger("transaction_type")->index("idx_transaction-type");

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unsignedBigInteger(AccountingInvoiceTransaction::STAMP_DISCOUNT)->index(AccountingInvoiceTransaction::IDX_STAMP_DISCOUNT)->nullable();
            $table->timestamp(AccountingInvoiceTransaction::DISCOUNT_AT)->nullable();
            $table->unsignedBigInteger(AccountingInvoiceTransaction::STAMP_DISCOUNT_BY)->nullable();

            $table->unique("transaction_id", "uidx_transaction-id");
            $table->unique(["transaction_id", "invoice_id"], "uidx_transaction-id_invoice_id");
            $table->unique(["transaction_uuid", "invoice_uuid"], "uidx_transaction-uuid_invoice-uuid");
            $table->unique(["invoice_id", "transaction_id"], "uidx_invoice-id_transaction_id");
            $table->unique(["invoice_uuid", "transaction_uuid"], "uidx_invoice-uuid_transaction-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_invoices_transactions');
    }
}
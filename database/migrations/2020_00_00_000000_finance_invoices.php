<?php

use App\Models\{BaseModel, Accounting\AccountingInvoice};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FinanceInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_invoices', function (Blueprint $table) {
            $table->bigIncrements("invoice_id");
            $table->uuid("invoice_uuid")->unique("uidx_invoice-uuid");

            $table->unsignedBigInteger("app_id")->index("idx_app-id");
            $table->uuid("app_uuid")->index("idx_app-uuid");

            $table->unsignedBigInteger("user_id")->index("idx_user-id");
            $table->uuid("user_uuid")->index("idx_user-uuid");

            $table->unsignedBigInteger("invoice_type")->index("idx_invoice-type");
            $table->date("invoice_date");
            $table->float("invoice_amount", 8, 2);
            $table->string("invoice_status", 10);
            $table->unsignedBigInteger("invoice_coupon")->unique("uidx_invoice-coupon")->nullable();
            $table->integer("invoice_discount")->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unsignedBigInteger(AccountingInvoice::STAMP_DISCOUNT)->index(AccountingInvoice::IDX_STAMP_DISCOUNT)->nullable();
            $table->timestamp(AccountingInvoice::DISCOUNT_AT)->nullable();
            $table->unsignedBigInteger(AccountingInvoice::STAMP_DISCOUNT_BY)->nullable();

            $table->unique("invoice_id", "uidx_invoice-id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_invoices');
    }
}
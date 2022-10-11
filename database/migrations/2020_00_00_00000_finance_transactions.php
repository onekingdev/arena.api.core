<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class FinanceTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("finance_transactions", function (Blueprint $objTable) {
            $objTable->bigIncrements("transaction_id");
            $objTable->uuid("transaction_uuid")->unique("uidx_transaction-uuid");
            $objTable->unsignedBigInteger("app_id")->index("idx_app-id");
            $objTable->uuid("app_uuid")->index("idx_app-uuid");
            $objTable->string("app_table", 175);
            $objTable->string("app_field", 25);
            $objTable->unsignedBigInteger("app_field_id")->index("idx_app-field-id");
            $objTable->uuid("app_field_uuid")->index("idx_app-field-uuid");
            $objTable->float("transaction_amount");
            $objTable->string("transaction_name", 175);
            $objTable->string("transaction_memo", 200);
            $objTable->string("transaction_status", 25);
            $objTable->string("transaction_type", 5)->index("idx_transaction-type");

            $objTable->timestamp(BaseModel::TRANSACTION_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_TRANSACTION)->index(BaseModel::IDX_STAMP_TRANSACTION)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_TRANSACTION_BY)->nullable();

            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("transaction_id", "uidx_transaction-id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("finance_transactions");
    }
}
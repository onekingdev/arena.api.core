<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class UsersFinancialPaypal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users_financial_paypal", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id");
            $objTable->uuid("user_uuid")->index("idx_user-uuid");
            $objTable->string("paypal", 500)->unique("uidx_paypal");
            $objTable->boolean("flag_primary")->default(false);

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::IDX_STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::IDX_STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::IDX_STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("row_id", "uidx_row-id");
            $objTable->unique(["user_id", "paypal"], "uidx_user-id_paypal");
            $objTable->unique(["user_uuid", "paypal"], "uidx_user-uuid_paypal");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("users_financial_paypal");
    }
}
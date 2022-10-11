<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class FinanceTypesInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("finance_types_invoices", function (Blueprint $table) {
            $table->bigIncrements("type_id");
            $table->uuid("type_uuid")->unique("uidx_type-uuid");
            $table->unsignedBigInteger("app_id")->index("idx_app-id");
            $table->uuid("app_uuid")->index("idx_app-uuid");
            $table->string("type_name", 50)->unique("uidx_type-name");
            $table->string("type_code", 5)->unique("uidx_type-code");

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unique("type_id", "uidx_type-id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("finance_types_invoices");
    }
}
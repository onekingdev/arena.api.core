<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockServicesTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists("soundblock_services_transactions");
        Schema::create("soundblock_services_transactions", function (Blueprint $objTable) {
            $objTable->bigIncrements("transaction_id");
            $objTable->uuid("transaction_uuid")->unique("uidx_transaction-uuid");
            $objTable->unsignedBigInteger("service_id")->index("idx_service-id");
            $objTable->uuid("service_uuid")->index("udx_service-uuid");
            $objTable->unsignedBigInteger("ledger_id")->unique("uidx_ledger-id");
            $objTable->uuid("ledger_uuid")->unique("uidx_ledger-uuid");
            $objTable->unsignedBigInteger("charge_type_id")->index("idx_charge-type-id");
            $objTable->uuid("charge_type_uuid")->index("idx_charge-type-uuid");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

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
        //
        Schema::dropIfExists("soundblock_services_transactions");
    }
}

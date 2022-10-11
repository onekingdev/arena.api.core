<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceFailedPaymentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::dropIfExists('finance_failed_payments');
        // Schema::create('finance_failed_payments', function (Blueprint $table) {
        //     $table->bigIncrements("row_id")->index("idx_invite-id");
        //     $table->uuid("row_uuid")->index("idx_invite-uuid");


        //     $table->unsignedBigInteger("service_id")->index("idx_service-id");
        //     $table->unsignedBigInteger("service_uuid")->index("idx_service-uuid");

        //     $table->text("fail_reason");

        //     $table->float("failed_amount", 2);
        //     $table->date("failed_date");

        //     $table->string("failed_stripe_payment_id");
        //     $table->string("failed_stripe_card_brand");
        //     $table->string("failed_stripe_card_last_four");

        //     $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
        //     $table->timestamp(BaseModel::CREATED_AT)->nullable();
        //     $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

        //     $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
        //     $table->timestamp(BaseModel::UPDATED_AT)->nullable();
        //     $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

        //     $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
        //     $table->timestamp(BaseModel::DELETED_AT)->nullable();
        //     $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('finance_failed_payments');
    }
}

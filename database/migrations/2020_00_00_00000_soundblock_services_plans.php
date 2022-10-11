<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockServicesPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists("soundblock_services_plans");
        Schema::create("soundblock_services_plans", function (Blueprint $objTable) {
            $objTable->bigIncrements("plan_id");
            $objTable->uuid("plan_uuid")->unique("uidx_plan-uuid");
            $objTable->unsignedBigInteger("service_id");
            $objTable->uuid("service_uuid");
            $objTable->unsignedBigInteger("ledger_id")->nullable()->unique("uidx_ledger-id");
            $objTable->uuid("ledger_uuid")->nullable()->unique("uidx_ledger-uuid");

            $objTable->float("plan_cost", 4, 2);
            $objTable->unsignedTinyInteger("plan_day");

            $objTable->string("plan_type", 25);
            $objTable->boolean("flag_active")->default(false);
            $objTable->unsignedInteger("version")->default(1);

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unique("plan_id", "uidx_plan-id");
            $objTable->unique(["plan_uuid", "service_uuid"], "uidx_plan-uuid_service-uuid");
            $objTable->unique(["service_uuid", "plan_uuid"], "uidx_service-uuid_plan-uuid");
            $objTable->unique(["service_id", "plan_id"], "uidx_service-id_plan-id");
            $objTable->unique(["plan_id", "service_id"], "uidx_plan-id_service-id");

            // $objTable->unique(["plan_id", "account_id", "ledger_id"], "uidx_plan-id_account-id_ledger-id");
            // $objTable->unique(["plan_id", "ledger_id", "account_id"], "uidx_plan-id_ledger-id_account-id");
            // $objTable->unique(["account_id", "plan_id", "ledger_id"], "uidx_account-id_plan-id_ledger-id");
            // $objTable->unique(["account_id", "ledger_id", "plan_id"], "uidx_account-id_ledger-id_plan-id");
            // $objTable->unique(["ledger_id", "account_id", "plan_id"], "uidx_ledger-id_account-id_plan-id");
            // $objTable->unique(["ledger_id", "plan_id", "account_id"], "uidx_ledger-id_plan-id_account-id");

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
        Schema::dropIfExists("soundblock_services_plans");
    }
}

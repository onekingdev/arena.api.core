<?php

use App\Models\BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoundblockDataPlansTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_data_plans_types", function (Blueprint $objTable) {
            $objTable->bigIncrements("data_id")->unique("uidx_data-id");
            $objTable->uuid("data_uuid")->unique("uidx_data-uuid");

            $objTable->string("plan_name")->index("idx_plan-name");
            $objTable->float("plan_rate")->index("idx_plan-rate");
            $objTable->integer("plan_diskspace")->index("idx_plan-discspace");
            $objTable->integer("plan_bandwidth")->index("idx_plan-bandwidth");
            $objTable->float("plan_additional_bandwidth")->index("idx_plan-additional-bandwidth");
            $objTable->integer("plan_users")->index("idx_plan-users");
            $objTable->float("plan_additional_user")->index("idx_plan-additional-users");
            $objTable->integer("plan_level")->index("idx_plan-level");
            $objTable->integer("plan_version")->index("idx_plan-version");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soundblock_data_plans_types');
    }
}

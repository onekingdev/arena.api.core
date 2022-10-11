<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractUserHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soundblock_projects_contracts_users_history', function (Blueprint $table) {
            $table->bigIncrements("row_id")->index("idx_row-id");
            $table->uuid("row_uuid")->index("idx_row-uuid");

            $table->integer("user_id")->index("idx_user-id");
            $table->uuid("user_uuid")->index("idx_user-uuid");
            $table->integer("contract_id")->index("idx_contract-id");
            $table->uuid("contract_uuid")->index("idx_contract-uuid");

            $table->json("contract_users_state");
            $table->string("history_event");
            $table->integer("contract_version")->default(1);

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soundblock_projects_contracts_users_history');
    }
}

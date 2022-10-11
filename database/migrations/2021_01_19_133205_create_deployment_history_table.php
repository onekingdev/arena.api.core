<?php

use App\Models\BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeploymentHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_projects_deployments_history", function (Blueprint $table) {
            $table->bigIncrements("row_id")->index("idx_row-id")->unique("uidx_row-id");
            $table->uuid("row_uuid")->index("idx_row-uuid")->unique("uidx_row-uuid");

            $table->unsignedBigInteger("deployment_id")->index("idx_deployment-id");
            $table->uuid("deployment_uuid")->index("idx_deployment-uuid");

            $table->unsignedBigInteger("collection_id")->index("idx_collection-id");
            $table->uuid("collection_uuid")->index("idx_collection-uuid");

            $table->unsignedBigInteger("platform_id")->index("idx_platform-id");
            $table->uuid("platform_uuid")->index("idx_platform-uuid");

            $table->string("flag_action");

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
        Schema::dropIfExists("soundblock_projects_deployments_history");
    }
}

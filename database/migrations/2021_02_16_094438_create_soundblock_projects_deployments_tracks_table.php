<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundblockProjectsDeploymentsTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_projects_deployments_metadata", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id")->index("idx_row-id")->unique("uidx_row-id");
            $objTable->uuid("row_uuid")->index("idx_row-id")->unique("uidx_row-uuid");

            $objTable->unsignedBigInteger("deployment_id")->index("idx_deployment-id");
            $objTable->uuid("deployment_uuid")->index("idx_deployment-uuid");

            $objTable->json("metadata_json");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->index(["deployment_id", "stamp_deleted_at"], "idx_deployment-id_stamp-deleted-at");
            $objTable->index(["deployment_uuid", "stamp_deleted_at"], "idx_deployment-uuid_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_projects_deployments_metadata");
    }
}

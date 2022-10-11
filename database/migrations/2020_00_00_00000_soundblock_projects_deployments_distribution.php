<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockProjectsDeploymentsDistribution extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists("soundblock_projects_deployments_distribution");
        Schema::create("soundblock_projects_deployments_distribution", function (Blueprint $objTable) {

            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("row_uuid");

            $objTable->unsignedBigInteger("deployment_id")->index("deployment_id");
            $objTable->uuid("deployment_uuid")->index("deployment_uuid");

            $objTable->unsignedBigInteger("geography_id")->index("geography_id");
            $objTable->uuid("geography_uuid")->index("geography_uuid");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->index("row_id", "row_id");

            $objTable->index(["deployment_id", "geography_id"], "deploy_index");
            $objTable->index(["deployment_uuid", "geography_uuid"], "deploy_uuid_index");
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
        Schema::dropIfExists("soundblock_projects_deployments_distribution");
    }
}

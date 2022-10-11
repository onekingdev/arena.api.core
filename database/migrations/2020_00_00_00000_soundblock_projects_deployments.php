<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SoundblockProjectsDeployments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_projects_deployments", function (Blueprint $objTable) {
            $objTable->bigIncrements("deployment_id");
            $objTable->uuid("deployment_uuid")->unique("deployment_uuid");
            $objTable->unsignedBigInteger("project_id")->index("idx_project-id");
            $objTable->uuid("project_uuid")->index("idx_project-uuid");
            $objTable->unsignedBigInteger("collection_id")->index("idx_collection-id");
            $objTable->uuid("collection_uuid")->index("idx_collection-uuid");

            $objTable->unsignedBigInteger("platform_id")->index("platform_id");
            $objTable->uuid("platform_uuid")->index("platform_uuid");

            $objTable->string("deployment_status", 10)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->index("deployment_id", "deployment_id");

            $objTable->index(["project_id", "platform_id"], "uidx_project-id_platorm-id");
            $objTable->index(["platform_id", "project_id"], "uidx_platform-id_project-id");
            $objTable->index(["project_uuid", "platform_uuid"], "uidx_project-uuid_platorm-uuid");
            $objTable->index(["platform_id", "project_id"], "uidx_platform-uuid_project-uuid");

            $objTable->unique(["collection_id", "platform_id"], "uidx_collection-id_platorm-id");
            $objTable->unique(["platform_id", "collection_id"], "uidx_platform-id_collection-id");
            $objTable->unique(["collection_uuid", "platform_uuid"], "uidx_collection-uuid_platorm-uuid");
            $objTable->unique(["platform_uuid", "collection_uuid"], "uidx_platform-uuid_collection-uuid");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_projects_deployments");
    }
}

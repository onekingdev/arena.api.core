<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockProjectsDrafts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("soundblock_projects_drafts");
        Schema::create("soundblock_projects_drafts", function (Blueprint $objTable) {
            $objTable->bigIncrements("draft_id");
            $objTable->uuid("draft_uuid")->unique("uidx_draft-uuid");
            $objTable->unsignedBigInteger("service_id")->index("idx_service-id");
            $objTable->uuid("service_uuid")->index("idx_service-uuid");
            $objTable->json("draft_json")->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("draft_id", "idx_draft-id");
            $objTable->unique(["service_id", "draft_id"], "uidx_service-id_draft-id");
            $objTable->unique(["draft_id", "service_id"], "uidx_draft-id_service-id");
            $objTable->unique(["service_uuid", "draft_uuid"], "uidx_service-uuid_draft-uuid");
            $objTable->unique(["draft_uuid", "service_uuid"], "uidx_draft-uuid_service-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_projects_drafts");
    }
}

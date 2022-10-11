<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockProjectsNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_projects_notes", function (Blueprint $objTable) {
            $objTable->bigIncrements("note_id");
            $objTable->uuid("note_uuid")->unique("uidx_note-uuid");
            $objTable->unsignedBigInteger("project_id")->index("idx_project-id");
            $objTable->uuid("project_uuid")->index("idx_project-uuid");
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id");
            $objTable->uuid("user_uuid")->index("idx_user-uuid");
            $objTable->text("project_notes");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("note_id", "uidx_note-id");

            $objTable->index(["project_id", "user_id"], "idx_project-id_user-id");
            $objTable->index(["user_id", "project_id"], "idx_user-id_project-id");
            $objTable->index(["project_uuid", "user_uuid"], "idx_project-uuid_user-uuid");
            $objTable->index(["user_uuid", "project_uuid"], "idx_user-uuid_project-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_projects_notes");
    }
}

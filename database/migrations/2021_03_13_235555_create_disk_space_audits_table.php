<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiskSpaceAuditsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("soundblock_audit_diskspace", function (Blueprint $table) {
            $table->bigIncrements("row_id")->index("idx_row-id")->unique("uidx_row-id");
            $table->uuid("row_uuid")->index("idx_row-id")->unique("uidx_row-uuid");

            $table->unsignedBigInteger("project_id")->index("idx_project-id");
            $table->uuid("project_uuid")->index("idx_project-uuid");

            $table->bigInteger("file_size");

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->index(["project_id", "stamp_deleted_at"], "idx_project-id_stamp-deleted-at");
            $table->index(["project_uuid", "stamp_deleted_at"], "idx_project-uuid_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("soundblock_audit_diskspace");
    }
}

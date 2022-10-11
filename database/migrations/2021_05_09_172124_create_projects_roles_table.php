<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsRolesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("soundblock_data_projects_roles", function (Blueprint $table) {
            $table->bigIncrements("row_id");
            $table->uuid("row_uuid");

            $table->unsignedBigInteger("project_role_id");
            $table->uuid("project_role_uuid");

            $table->string("project_role_name");

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->index(["row_id", "stamp_deleted_at"], "idx_row-id_stamp-deleted-at");
            $table->index(["row_uuid", "stamp_deleted_at"], "idx_row-uuid_stamp-deleted-at");

            $table->index(["project_role_id", "stamp_deleted_at"], "idx_project-role-id_stamp-deleted-at");
            $table->index(["project_role_uuid", "stamp_deleted_at"], "idx_project-role-uuid_stamp-deleted-at");

            $table->index(["project_role_name", "stamp_deleted_at"], "idx_project-role-name_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("soundblock_data_projects_roles");
    }
}

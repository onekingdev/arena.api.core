<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsBandwidthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_projects_bandwidth", function (Blueprint $table) {
            $table->bigIncrements("row_id")->index("idx_row-id")->unique("uidx_row-id");
            $table->uuid("row_uuid")->index("idx_row-id")->unique("uidx_row-uuid");

            $table->unsignedBigInteger("project_id")->index("idx_project-id");
            $table->uuid("project_uuid")->index("idx_project-uuid");

            $table->unsignedBigInteger("user_id")->index("idx_user-id");
            $table->uuid("user_uuid")->index("idx_user-uuid");

            $table->bigInteger("file_size");
            $table->string("flag_action")->index("idx_flag-action");

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

            $table->index(["user_id", "stamp_deleted_at"], "idx_user-id_stamp-deleted-at");
            $table->index(["user_uuid", "stamp_deleted_at"], "idx_user-uuid_stamp-deleted-at");

            $table->index(["project_id", "flag_action", "stamp_deleted_at"], "idx_project-id_flag-action_stamp-deleted-at");
            $table->index(["project_uuid", "flag_action", "stamp_deleted_at"], "idx_project-uuid_flag-action_stamp-deleted-at");

            $table->index(["user_id", "flag_action", "stamp_deleted_at"], "idx_user-id_flag-action_stamp-deleted-at");
            $table->index(["user_uuid", "flag_action", "stamp_deleted_at"], "idx_user-uuid_flag-action_stamp-deleted-at");

            $table->index(["project_id", "user_id", "stamp_deleted_at"], "idx_project-id_user-id_stamp-deleted-at");
            $table->index(["project_uuid", "user_uuid", "stamp_deleted_at"], "idx_project-uuid_user-uuid_stamp-deleted-at");

            $table->index(["project_id", "user_id", "flag_action", "stamp_deleted_at"], "idx_project-id_user-id_flag-action_stamp-deleted-at");
            $table->index(["project_uuid", "user_uuid", "flag_action", "stamp_deleted_at"], "idx_project-uuid_user-uuid_flag-action_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_projects_bandwidth");
    }
}

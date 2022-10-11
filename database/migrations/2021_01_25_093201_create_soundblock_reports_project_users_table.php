<?php

use App\Models\BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoundblockReportsProjectUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_reports_projects_users", function (Blueprint $table) {
            $table->bigIncrements("row_id")->index("idx_row-id")->unique("uidx_row-id");
            $table->uuid("row_uuid")->index("idx_row-uuid")->unique("uidx_row-uuid");

            $table->unsignedBigInteger("project_id")->index("idx_project-id");
            $table->uuid("project_uuid")->index("idx_project-uuid");

            $table->unsignedBigInteger("user_id")->index("idx_user-id");
            $table->uuid("user_uuid")->index("idx_user-uuid");

            $table->date("date_starts");
            $table->date("date_ends");
            $table->float("report_revenue", 18, 10);
            $table->string("report_currency");

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
        Schema::dropIfExists("soundblock_reports_projects_users");
    }
}

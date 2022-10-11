<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->create("projects_drafts", function (Blueprint $table) {
            $table->bigIncrements("draft_id")->index("idx_draft-id")->unique("uidx_draft-id");
            $table->uuid("draft_uuid")->index("idx_draft-uuid")->unique("uidx_draft-uuid");

            $table->unsignedBigInteger("group_id")->index("idx_group-id");
            $table->uuid("group_uuid")->index("idx_group-uuid");

            $table->unsignedBigInteger("user_id")->nullable()->index("idx_user-id");
            $table->uuid("user_uuid")->nullable()->index("idx_user-uuid");

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
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
        Schema::connection("mysql-music")->dropIfExists("projects_drafts");
    }
}

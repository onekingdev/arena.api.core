<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class OfficeContactUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("office_contact_users", function (Blueprint $table) {
            $table->bigIncrements("row_id");
            $table->uuid("row_uuid")->unique("uidx_row-uuid");
            $table->unsignedBigInteger("contact_id")->index("idx_contact-id");
            $table->uuid("contact_uuid")->index("idx_contact-uuid");
            $table->unsignedBigInteger("user_id")->index("idx_user-id");
            $table->uuid("user_uuid")->index("idx_user-uuid");
            $table->boolean("flag_read")->index("idx_flag-read")->default(false);
            $table->boolean("flag_archive")->index("idx_flag-archive")->default(false);
            $table->boolean("flag_delete")->index("idx_flag-delete")->default(false);

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unique("row_id", "uidx_row-id");
            $table->unique(["contact_id", "user_id"], "uidx_contact-id_user-id");
            $table->unique(["contact_uuid", "user_uuid"], "uidx_contact-uuid_user-uuid");
            $table->unique(["user_id", "contact_id"], "uidx_user-id_contact-id");
            $table->unique(["user_uuid", "contact_uuid"], "uidx_user-uuid_contact-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("office_contact_users");
    }
}

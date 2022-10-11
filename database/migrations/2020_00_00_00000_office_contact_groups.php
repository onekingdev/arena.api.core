<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class OfficeContactGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_contact_groups', function (Blueprint $table) {
            $table->bigIncrements("row_id");
            $table->uuid("row_uuid")->unique("uidx_row-uuid");
            $table->unsignedBigInteger("contact_id")->index("idx_contact-id");
            $table->uuid("contact_uuid")->index("idx_contact-uuid");
            $table->unsignedBigInteger("group_id")->index("idx_group-id");
            $table->uuid("group_uuid")->index("idx_group-uuid");
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
            $table->unique(["contact_id", "group_id"], "uidx_contact-id_group-id");
            $table->unique(["contact_uuid", "group_uuid"], "uidx_contact-uuid_group-uuid");
            $table->unique(["group_id", "contact_id"], "uidx_group-id_contact-id");
            $table->unique(["group_uuid", "contact_uuid"], "uidx_group-uuid_contact-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('office_contact_groups');
    }
}

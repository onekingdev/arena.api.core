<?php

use App\Models\BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreCorrespondenceAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_correspondence_attachments', function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id")->index("idx_row-id");
            $objTable->uuid("row_uuid")->index("uidx_row-uuid");

            $objTable->unsignedBigInteger("correspondence_id")->index("idx_correspondence-id");
            $objTable->uuid("correspondence_uuid")->index("uidx_correspondence-uuid");

            $objTable->string("file_name");
            $objTable->string("file_type");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_correspondence_attachments');
    }
}

<?php

use App\Models\BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreCorrespondenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_correspondence', function (Blueprint $objTable) {
            $objTable->bigIncrements("correspondence_id")->index("idx_correspondence-id");
            $objTable->uuid("correspondence_uuid")->index("uidx_correspondence-uuid");

            $objTable->unsignedBigInteger("app_id")->index("idx_app-id");
            $objTable->uuid("app_uuid")->index("uidx_app-uuid");

            $objTable->unsignedBigInteger("email_id")->index("idx_email-id")->nullable();
            $objTable->uuid("email_uuid")->index("uidx_email-uuid")->nullable();

            $objTable->string("email_address")->nullable();
            $objTable->string("email_subject");
            $objTable->json("email_json");

            $objTable->string("remote_addr");
            $objTable->string("remote_host");

            $objTable->boolean("flag_read")->default(false);
            $objTable->boolean("flag_archived")->default(false);
            $objTable->boolean("flag_received")->default(false);

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
        Schema::dropIfExists('core_correspondence');
    }
}

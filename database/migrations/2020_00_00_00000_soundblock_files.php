<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SoundblockFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_files", function (Blueprint $objTable) {
            $objTable->bigIncrements("file_id");
            $objTable->uuid("file_uuid")->unique("file_uuid");
            $objTable->string("file_name", 200);
            $objTable->string("file_title", 175)->nullable();
            $objTable->string("file_category", 5);
            $objTable->string("file_path", 500)->nullable();
            $objTable->string("file_sortby", 500);

            $objTable->unsignedBigInteger("file_size")->nullable();
            $objTable->string("file_md5", 32);

            $objTable->unsignedBigInteger("directory_id")->nullable()->index("directory_id");
            $objTable->uuid("directory_uuid")->nullable()->index("directory_uuid");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_MODIFIED)->nullable()->index(BaseModel::STAMP_MODIFIED);
            $objTable->timestamp(BaseModel::MODIFIED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_MODIFIED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->index("file_id", "file_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_files");
    }
}

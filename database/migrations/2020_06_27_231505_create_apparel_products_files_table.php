<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelProductsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("apparel_products_files", function (Blueprint $table) {
            $table->bigIncrements("row_id")->unique("uidx_row-id")->index("idx_row-id");
            $table->uuid("row_uuid")->unique("uidx_row-uuid")->index("idx_row-uuid");

            $table->unsignedBigInteger("file_id")->index("idx_file-id");
            $table->uuid("file_uuid")->index("idx_file-uuid");

            $table->unsignedBigInteger("product_id")->index("idx_product-id");
            $table->uuid("product_uuid")->index("idx_product-uuid");

            $table->unsignedBigInteger("color_id")->index("idx_color-id")->nullable();
            $table->uuid("color_uuid")->index("idx_color-uuid")->nullable();

            $table->string("file_type")->index("idx_file-type");

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
        Schema::dropIfExists("apparel_products_files");
    }
}

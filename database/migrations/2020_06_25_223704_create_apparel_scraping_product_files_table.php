<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelScrapingProductFilesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("apparel_scraping_products_files", function (Blueprint $table) {
            $table->bigIncrements("row_id")->index("idx_row-id");
            $table->uuid("row_uuid")->unique("uidx_row-uuid")->index("idx_row-uuid");

            $table->unsignedBigInteger("file_id")->index("idx_file-id");
            $table->uuid("file_uuid")->unique("uidx_file-uuid")->index("idx_file-uuid");

            $table->unsignedBigInteger("product_id")->index("idx_product-id");
            $table->uuid("product_uuid")->index("idx_product-uuid");

            $table->unsignedBigInteger("color_id")->index("idx_color-id")->nullable();
            $table->uuid("color_uuid")->index("idx_color-uuid")->nullable();

            $table->string("type")->index("idx_type");

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unique(["file_id", "product_id"], "uidx_file_id_product_id");
            $table->unique(["file_uuid", "product_uuid"], "uidx_file_uuid_product_uuid");
            $table->unique(["file_id", "product_id"], "uidx_file-id_product_id");
            $table->unique(["product_uuid", "file_uuid"], "uidx_product_uuid_file_uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("apparel_scraping_products_files");
    }
}

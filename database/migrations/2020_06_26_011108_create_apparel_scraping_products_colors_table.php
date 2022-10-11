<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelScrapingProductsColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("apparel_scraping_products_colors", function (Blueprint $table) {
            $table->bigIncrements("row_id")->index("idx_row-id");
            $table->uuid("row_uuid")->index("idx_row-uuid")->unique("uidx_row-uuid");

            $table->unsignedBigInteger("product_id")->index("idx_product-id");
            $table->uuid("product_uuid")->index("idx_product-uuid");

            $table->unsignedBigInteger("color_id")->index("idx_color-id");
            $table->uuid("color_uuid")->index("idx_color-uuid");

            $table->unsignedBigInteger("thumbnail_id")->nullable()->index("idx_thumbnail-id");
            $table->uuid("thumbnail_uuid")->nullable()->index("idx_thumbnail-uuid");

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
        Schema::dropIfExists("apparel_scraping_products_colors");
    }
}

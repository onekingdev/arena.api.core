<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelScrapingProductsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("apparel_scraping_products", function (Blueprint $table) {
            $table->bigIncrements("product_id")->index("idx_product-id");
            $table->uuid("product_uuid")->index("idx_product-uuid");

            $table->string("ascolour_id", 5);
            $table->unsignedBigInteger("ascolour_ref");

            $table->string("product_name");
            $table->string("product_short_description");
            $table->string("product_meta_description");
            $table->string("product_meta_keywords");
            $table->string("product_description");
            $table->float("product_price");
            $table->unsignedTinyInteger("product_weight")->default(0);

            $table->string("product_url");
            $table->json("product_json");

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unique("product_id", "uidx_product-id");
            $table->unique("product_uuid", "uidx_product-uuid");
            $table->unique("ascolour_ref", "uidx_ascolour-ref");
        });

        DB::statement("ALTER TABLE apparel_scraping_products ADD product_html LONGBLOB AFTER product_json");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("apparel_scraping_products");
    }
}

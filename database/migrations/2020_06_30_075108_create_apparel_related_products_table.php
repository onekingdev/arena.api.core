<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelRelatedProductsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("apparel_related_products", function (Blueprint $table) {
            $table->bigIncrements("row_id");
            $table->uuid("row_uuid");

            $table->unsignedBigInteger("product_id")->index("idx_product-id");
            $table->uuid("product_uuid")->index("idx_product-uuid");

            $table->unsignedBigInteger("related_id")->index("idx_related-id")->nullable();
            $table->uuid("related_uuid")->index("idx_related-uuid")->nullable();

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
    public function down() {
        Schema::dropIfExists("apparel_related_products");
    }
}

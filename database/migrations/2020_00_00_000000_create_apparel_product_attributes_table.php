<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparel_products_attributes', function (Blueprint $table) {
            $table->bigIncrements('row_id')->index('idx_row-id');
            $table->uuid('row_uuid')->index('idx_row-uuid');

            $table->unsignedBigInteger('attribute_id')->index('idx_attribute-id');
            $table->uuid('attribute_uuid')->index('idx_attribute-uuid');
            $table->unsignedBigInteger('product_id')->index('idx_product-id');
            $table->uuid('product_uuid')->index('idx_product-uuid');


            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unique('row_id', 'uidx_row-id');
            $table->unique('row_uuid', 'uidx_row-uuid');

            $table->unique(['row_id', 'attribute_id'], 'uidx_row-id_attribute-id');
            $table->unique(['row_uuid', 'attribute_uuid'], 'uidx_row-uuid_attribute-uuid');
            $table->unique(['attribute_id', 'row_id'], 'uidx_attribute-id_row-id');
            $table->unique(['attribute_uuid', 'row_uuid'], 'uidx_attribute-uuid_row-uuid');

            $table->unique(['row_id', 'product_id'], 'uidx_row-id_product-id');
            $table->unique(['row_uuid', 'product_uuid'], 'uidx_row-uuid_product-uuid');
            $table->unique(['product_id', 'row_id'], 'uidx_product-id_row-id');
            $table->unique(['product_uuid', 'row_uuid'], 'uidx_product-uuid_row-uuid');

            $table->unique(['attribute_id', 'product_id'], 'uidx_attribute-id_product-id');
            $table->unique(['attribute_uuid', 'product_uuid'], 'uidx_attribute-uuid_product-uuid');
            $table->unique(['product_id', 'attribute_id'], 'uidx_product-id_attribute-id');
            $table->unique(['product_uuid', 'attribute_uuid'], 'uidx_product-uuid_attribute-uuid');

            $table->unique(['row_id', 'attribute_id', 'product_id'], 'uidx_row-id_attribute-id_product-id');
            $table->unique(['attribute_id', 'row_id', 'product_id'], 'uidx_attribute-id_row-id_product-id');
            $table->unique(['attribute_id', 'product_id', 'row_id'], 'uidx_attribute-id_product-id_row-id');
            $table->unique(['product_id', 'attribute_id', 'row_id'], 'uidx_product-id_attribute-id_row-id');
            $table->unique(['product_id', 'row_id', 'attribute_id'], 'uidx_product-id_row-id_attribute-id');
            $table->unique(['row_id', 'product_id', 'attribute_id'], 'uidx_row-id_product-id_attribute-id');

            $table->unique(['row_uuid', 'attribute_uuid', 'product_uuid'], 'uidx_row-uuid_attribute-uuid_product-uuid');
            $table->unique(['attribute_uuid', 'row_uuid', 'product_uuid'], 'uidx_attribute-uuid_row-uuid_product-uuid');
            $table->unique(['attribute_uuid', 'product_uuid', 'row_uuid'], 'uidx_attribute-uuid_product-uuid_row-uuid');
            $table->unique(['product_uuid', 'attribute_uuid', 'row_uuid'], 'uidx_product-uuid_attribute-uuid_row-uuid');
            $table->unique(['product_uuid', 'row_uuid', 'attribute_uuid'], 'uidx_product-uuid_row-uuid_attribute-uuid');
            $table->unique(['row_uuid', 'product_uuid', 'attribute_uuid'], 'uidx_row-uuid_product-uuid_attribute-uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apparel_products_attributes');
    }
}

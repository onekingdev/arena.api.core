<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelProductStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparel_products_styles', function (Blueprint $table) {
            $table->bigIncrements('row_id')->index('idx_row-id');
            $table->uuid('row_uuid')->index('idx_row-uuid');

            $table->unsignedBigInteger('product_id')->index('idx_product-id');
            $table->uuid('product_uuid')->index('idx_product-uuid');
            $table->unsignedBigInteger('ascolour_ref');
            $table->string('style_name');

            $table->unsignedBigInteger('image_id')->nullable()->index('idx_image-id');
            $table->uuid('image_uuid')->nullable()->index('idx_image-uuid');
            $table->unsignedBigInteger('thumbnail_id')->nullable()->index('idx_thumbnail-id');
            $table->uuid('thumbnail_uuid')->nullable()->index('idx_thumbnail-uuid');

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unsignedBigInteger('preview_id')->nullable()->index('idx_preview-id');
            $table->uuid('preview_uuid')->nullable()->index('idx_preview-uuid');

            $table->unique('row_id', 'uidx_row-id');
            $table->unique('row_uuid', 'uidx_row-uuid');

            $table->unique(['row_id', 'product_id'], 'uidx_row-id_product-id');
            $table->unique(['row_uuid', 'product_uuid'], 'uidx_row-uuid_product-uuid');
            $table->unique(['product_id', 'row_id'], 'uidx_product-id_row-id');
            $table->unique(['product_uuid', 'row_uuid'], 'uidx_product-uuid_row-uuid');

            $table->unique(['row_id', 'image_id'], 'uidx_row-id_image-id');
            $table->unique(['row_uuid', 'image_uuid'], 'uidx_row-uuid_image-uuid');
            $table->unique(['image_id', 'row_id'], 'uidx_image-id_row-id');
            $table->unique(['product_uuid', 'image_uuid'], 'uidx_image-uuid_row-uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apparel_products_styles');
    }
}

<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelScrapingProductsStylesImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparel_scraping_products_styles_images', function (Blueprint $table) {
            $table->bigIncrements("row_id")->index("idx_row-id");
            $table->uuid("row_uuid")->index("idx_row-uuid");

            $table->unsignedBigInteger("style_id")->index("idx_style-id");
            $table->uuid("style_uuid")->index("idx_style-uuid");

            $table->unsignedBigInteger("file_id")->index("idx_file-id");
            $table->uuid("file_uuid")->index("idx_file-uuid");

            $table->string("flag_type")->index("idx_flag-type");

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

            $table->unique(['row_id', 'style_id'], 'uidx_row-id_style-id');
            $table->unique(['row_uuid', 'style_uuid'], 'uidx_row-uuid_style-uuid');
            $table->unique(['style_id', 'row_id'], 'uidx_style-id_row-id');
            $table->unique(['style_uuid', 'row_uuid'], 'uidx_style-uuid_row-uuid');

            $table->unique(['row_id', 'file_id'], 'uidx_row-id_file-id');
            $table->unique(['row_uuid', 'file_uuid'], 'uidx_row-uuid_file-uuid');
            $table->unique(['file_id', 'row_id'], 'uidx_file-id_row-id');
            $table->unique(['file_uuid', 'row_uuid'], 'uidx_file-uuid_row-uuid');

            $table->unique(['style_id', 'file_id'], 'uidx_style-id_file-id');
            $table->unique(['style_uuid', 'file_uuid'], 'uidx_style-uuid_file-uuid');
            $table->unique(['file_id', 'style_id'], 'uidx_file-id_style-id');
            $table->unique(['file_uuid', 'style_uuid'], 'uidx_file-uuid_style-uuid');

            $table->unique(['row_id', 'style_id', 'file_id'], 'uidx_row-id_style-id_file-id');
            $table->unique(['style_id', 'row_id', 'file_id'], 'uidx_style-id_row-id_file-id');
            $table->unique(['style_id', 'file_id', 'row_id'], 'uidx_style-id_file-id_row-id');
            $table->unique(['file_id', 'style_id', 'row_id'], 'uidx_file-id_style-id_row-id');
            $table->unique(['file_id', 'row_id', 'style_id'], 'uidx_file-id_row-id_style-id');
            $table->unique(['row_id', 'file_id', 'style_id'], 'uidx_row-id_file-id_style-id');

            $table->unique(['row_uuid', 'style_uuid', 'file_uuid'], 'uidx_row-uuid_style-uuid_file-uuid');
            $table->unique(['style_uuid', 'row_uuid', 'file_uuid'], 'uidx_style-uuid_row-uuid_file-uuid');
            $table->unique(['style_uuid', 'file_uuid', 'row_uuid'], 'uidx_style-uuid_file-uuid_row-uuid');
            $table->unique(['file_uuid', 'style_uuid', 'row_uuid'], 'uidx_file-uuid_style-uuid_row-uuid');
            $table->unique(['file_uuid', 'row_uuid', 'style_uuid'], 'uidx_file-uuid_row-uuid_style-uuid');
            $table->unique(['row_uuid', 'file_uuid', 'style_uuid'], 'uidx_row-uuid_file-uuid_style-uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apparel_scraping_products_styles_images');
    }
}

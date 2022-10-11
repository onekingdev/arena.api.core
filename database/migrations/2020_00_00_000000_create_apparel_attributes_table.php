<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApparelAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparel_data_attributes', function (Blueprint $table) {
            $table->bigIncrements('attribute_id')->index('idx_attribute-id');
            $table->uuid('attribute_uuid')->index('idx_attribute-uuid');

            $table->string('attribute_name')->index("idx_attribute-name");
            $table->string('attribute_type')->index("idx_attribute-type");

            $table->unsignedBigInteger("category_id")->index("idx_category-id");
            $table->uuid("category_uuid")->index("idx_category-uuid");

            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unsignedBigInteger('preview_id')->nullable()->index('idx_preview-id');
            $table->uuid('preview_uuid')->nullable()->index('idx_preview-uuid');

            $table->unique('attribute_id', 'uidx_attribute-id');
            $table->unique('attribute_uuid', 'uidx_attribute-uuid');

            $table->unique(["attribute_id", "category_id"], "uidx_attribute-id_category-id");
            $table->unique(["attribute_uuid", "category_uuid"], "uidx_attribute_uuid_category_uuid");
            $table->unique(["category_id", "attribute_id"], "uidx_category-id_attribute-id");
            $table->unique(["category_uuid", "attribute_uuid"], "uidx_category_uuid_attribute_uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apparel_data_attributes');
    }
}

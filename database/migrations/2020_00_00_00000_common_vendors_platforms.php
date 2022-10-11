<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CommonVendorsPlatforms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("common_vendors_platforms");
        Schema::create("common_vendors_platforms", function (Blueprint $objTable) {
            $objTable->bigIncrements("id");
            $objTable->bigInteger("platform_id")->unsigned()->unique("uidx_platform-id");
            $objTable->uuid("platform_uuid")->unique("uidx_platform-uuid");
            $objTable->string("name", 50)->unique();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("common_vendors_platforms");
    }
}

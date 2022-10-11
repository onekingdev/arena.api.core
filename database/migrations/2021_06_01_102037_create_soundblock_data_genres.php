<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundblockDataGenres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_data_genres", function (Blueprint $objTable) {
            $objTable->bigIncrements("data_id")->unique("uidx_data-id");
            $objTable->uuid("data_uuid")->unique("uidx_data-uuid");

            $objTable->string("data_code")->unique("uidx_data-code");
            $objTable->string("data_genre")->index("uidx_data-genre");

            $objTable->boolean("flag_primary")->index("idx_flag-primary");
            $objTable->boolean("flag_secondary")->index("idx_flag-secondary");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique(["data_code", "data_genre"], "uidx_data-code_data-genre");
            $objTable->unique(["data_genre", "flag_primary"], "uidx_data-genre_flag-primary");
            $objTable->unique(["data_genre", "flag_secondary"], "uidx_data-genre_flag-secondary");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_data_genres");
    }
}

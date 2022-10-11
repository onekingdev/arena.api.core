<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::connection("mysql-music")->create("styles", function (Blueprint $table) {
            $table->bigIncrements("style_id")->index("idx_style-id")->unique("uidx_style-id");
            $table->uuid("style_uuid")->index("idx_style-uuid")->unique("uidx_style-uuid");

            $table->string("style_name")->index("idx_style-name")->unique("uidx_style-name");

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
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
        Schema::connection("mysql-music")->dropIfExists("styles");
    }
}

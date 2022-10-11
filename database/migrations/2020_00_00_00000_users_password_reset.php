<?php

use App\Models\{BaseModel, Users\Auth\PasswordReset};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersPasswordReset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_password_reset', function (Blueprint $table) {
            $table->bigIncrements("row_id");
            $table->uuid("row_uuid")->unique("uidx_row-uuid");
            $table->unsignedBigInteger("user_id")->index("idx_user-id");
            $table->uuid("user_uuid")->index("idx_user-uuid");
            $table->string("reset_token", 250)->unique("uidx_reset-token");
            $table->boolean("flag_used")->default(false);

            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->timestamp(PasswordReset::EXPIRED_AT)->nullable();
            $table->unsignedBigInteger(PasswordReset::STAMP_EXPIRED)->index(PasswordReset::IDX_STAMP_EXPIRED)->nullable();
            $table->unsignedBigInteger(PasswordReset::STAMP_EXPIRED_BY)->nullable();

            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unique("row_id", "uidx_row-id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_password_reset');
    }
}

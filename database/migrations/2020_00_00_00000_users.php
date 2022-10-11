<?php

use App\Models\BaseModel;
use App\Models\Users\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users", function (Blueprint $objTable) {
            $objTable->bigIncrements("user_id");
            $objTable->uuid("user_uuid")->unique("user_uuid");
            $objTable->string("user_password", 200)->nullable();
            $objTable->string("name_first", 175)->nullable();
            $objTable->string("name_middle", 175)->nullable();
            $objTable->string("name_last", 175)->nullable();
            $objTable->boolean("flag_avatar")->default(false);
            $objTable->rememberToken();

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->index("user_id", "user_id");
        });
    }

    /**
     * Reverse the migrations.
     *  lXhCt9ilC0bzEe78v3bmWBERDOCWKhgY6i9kajmf
        *MH1dhJ4HjMnzj5O4SxJW2ZVVInvRXv4qT2Xdg0If
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("users");
    }
}

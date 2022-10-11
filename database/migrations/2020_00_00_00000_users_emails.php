<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Users\User;
use App\Models\BaseModel;
use App\Models\Users\Contact\UserContactEmail;

class UsersEmails extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("users_emails", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id");
            $objTable->uuid("user_uuid")->index("idx_user-uuid");
            $objTable->string("user_auth_email", 175)->unique("uidx_user-auth-email");
            $objTable->boolean("flag_primary")->index("idx_flag-primary")->default(false);
            $objTable->boolean("flag_verified")->index("idx_flag-verified")->default(false);
            $objTable->string("verification_hash")->index("idx_verification-hash")
                     ->unique("idx_verification-hash")->nullable();

            $objTable->unsignedBigInteger(UserContactEmail::STAMP_EMAIL)->index(UserContactEmail::IDX_STAMP_EMAIL)->nullable();
            $objTable->timestamp(UserContactEmail::EMAIL_AT)->nullable();
            $objTable->unsignedBigInteger(UserContactEmail::STAMP_EMAIL_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::IDX_STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::IDX_STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::IDX_STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("row_id", "uidx_row-id");
            $objTable->unique(["user_id", "user_auth_email"], "uidx_user-id_user-auth-email");
            $objTable->unique(["user_id", "user_auth_email"], "uidx_user-auth-email_user-id");
            $objTable->unique(["user_uuid", "user_auth_email"], "uidx_user-uuid_user-auth-email");
            $objTable->unique(["user_auth_email", "user_uuid"], "uidx_user-auth-email_user-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("users_emails");
    }
}

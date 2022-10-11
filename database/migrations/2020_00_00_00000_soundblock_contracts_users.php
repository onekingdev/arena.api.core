<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockContractsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_projects_contracts_users", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid")->unique("uidx_row-uuid");

            $objTable->unsignedBigInteger("contract_id")->index("idx_contract-id");
            $objTable->uuid("contract_uuid")->index("idx_contract-uuid");

            $objTable->unsignedBigInteger("user_id")->nullable()->index("idx_user-id");
            $objTable->uuid("user_uuid")->nullable()->index("idx_user-uuid");

            $objTable->unsignedBigInteger("invite_id")->nullable()->index("idx_invite-id");
            $objTable->uuid("invite_uuid")->nullable()->index("idx_invite-uuid");

            $objTable->string("contract_status")->index("idx_contract-status");
            $objTable->float("user_payout", 4, 2);

            $objTable->boolean("flag_notify")->default(false);
            $objTable->boolean("flag_email")->default(false);
            $objTable->integer("contract_version")->default(1);

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("row_id", "idx_row-id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_projects_contracts_users");
    }
}

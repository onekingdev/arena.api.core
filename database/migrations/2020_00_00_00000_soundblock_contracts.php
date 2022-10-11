<?php

use App\Models\BaseModel;
use App\Models\Soundblock\Projects\Contracts\Contract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SoundblockContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("soundblock_projects_contracts");
        Schema::create("soundblock_projects_contracts", function (Blueprint $objTable) {
            $objTable->bigIncrements("contract_id");
            $objTable->uuid("contract_uuid")->unique("uidx_contract-uuid");

            $objTable->unsignedBigInteger("service_id")->index("idx_service-id")->nullable();
            $objTable->uuid("service_uuid")->index("idx_service-uuid")->nullable();

            $objTable->unsignedBigInteger("project_id")->index("idx_project-id");
            $objTable->uuid("project_uuid")->index("idx_project-uuid");

            $objTable->unsignedBigInteger("ledger_id")->index("idx_ledger-id")->nullable();
            $objTable->uuid("ledger_uuid")->index("idx_ledger-uuid")->nullable();

            $objTable->string("flag_status", 10)->index("idx_flag-status")->default("Pending");
            $objTable->integer("contract_version")->default(1);

            $objTable->unsignedBigInteger(Contract::STAMP_BEGINS)->index(Contract::IDX_STAMP_BEGINS)->nullable();
            $objTable->unsignedBigInteger(Contract::STAMP_ENDS)->index(Contract::IDX_STAMP_ENDS)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("contract_id", "uidx_contract-id");
            $objTable->index(["service_id", "project_id"], "idx_service-id_project-id");
            $objTable->index(["project_id", "service_id"], "idx_project-id_service-id");
            $objTable->index(["service_uuid", "project_uuid"], "idx_service-uuid_project-uuid");
            $objTable->index(["project_uuid", "service_uuid"], "idx_project-uuid_service-uuid");

            $objTable->unique(["contract_id", "ledger_id"], "uidx_contract-id_ledger_id");
            $objTable->unique(["ledger_id", "contract_id"], "uidx_ledger_id_contract-id");
            $objTable->unique(["contract_uuid", "ledger_uuid"], "uidx_contract-uuid_ledger_uuid");
            $objTable->unique(["ledger_uuid", "contract_uuid"], "uidx_ledger_uuid_contract-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_projects_contracts");
    }
}

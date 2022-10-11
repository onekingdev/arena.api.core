<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("soundblock_ledger", function (Blueprint $objTable) {

            $objTable->bigIncrements("ledger_id");
            $objTable->uuid("ledger_uuid")->unique("uidx_ledger-uuid");
            $objTable->string("ledger_name", 175);
            $objTable->string("ledger_memo", 500);
            $objTable->string("qldb_id", 175)->index("idx_qldb-id")->nullable();
            $objTable->string("qldb_table", 175)->index("idx_qldb-table");
            $objTable->json("qldb_block")->nullable();
            $objTable->json("qldb_data");
            $objTable->json("qldb_hash")->nullable();
            $objTable->json("qldb_metadata")->nullable();

            $objTable->string("table_name");
            $objTable->string("table_field");
            $objTable->unsignedBigInteger("table_id")->index("idx_table-id");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("ledger_id", "uidx_ledger-id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("soundblock_ledger");
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLedgerColumnsToSoundblockProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects", function (Blueprint $table) {
            $table->unsignedBigInteger("ledger_id")->nullable()->after("service_uuid");
            $table->uuid("ledger_uuid")->nullable()->after("ledger_id");
            $table->index(["ledger_id", "stamp_deleted_at"], "idx_ledger-id_stamp-deleted-at");
            $table->index(["ledger_uuid", "stamp_deleted_at"], "idx_ledger-uuid_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects", function (Blueprint $table) {
            $table->dropIndex("idx_ledger-id_stamp-deleted-at");
            $table->dropIndex("idx_ledger-uuid_stamp-deleted-at");

            $table->dropColumn("ledger_id");
            $table->dropColumn("ledger_uuid");
        });
    }
}

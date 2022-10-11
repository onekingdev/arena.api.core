<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeChargeTablesNameToAccounting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("charge_types_rates", "accounting_types_rates");
        Schema::table('accounting_types_rates', function (Blueprint $table) {
            $table->renameColumn("charge_type_id", "accounting_type_id");
            $table->renameColumn("charge_type_uuid", "accounting_type_uuid");
            $table->renameColumn("charge_version", "accounting_version");
            $table->renameColumn("charge_rate", "accounting_rate");
            $table->renameIndex("idx_charge-type-id", "idx_accounting-type-id");
            $table->renameIndex("idx_charge-type-uuid", "idx_accounting-type-uuid");
            $table->renameIndex("idx_charge-version", "idx_accounting-version");
        });

        Schema::rename("charge_types", "accounting_types");
        Schema::table('accounting_types', function (Blueprint $table) {
            $table->renameColumn("charge_type_id", "accounting_type_id");
            $table->renameColumn("charge_type_uuid", "accounting_type_uuid");
            $table->renameColumn("charge_type_name", "accounting_type_name");
            $table->renameColumn("charge_type_memo", "accounting_type_memo");
            $table->renameIndex("idx_charge-type-id", "idx_accounting-type-id");
            $table->renameIndex("idx_charge-type-uuid", "idx_accounting-type-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("accounting_types_rates", "charge_types_rates");
        Schema::table('charge_types_rates', function (Blueprint $table) {
            $table->renameColumn("accounting_type_id", "charge_type_id");
            $table->renameColumn("accounting_type_uuid", "charge_type_uuid");
            $table->renameColumn("accounting_version", "charge_version");
            $table->renameColumn("accounting_rate", "charge_rate");
            $table->renameIndex("idx_accounting-type-id", "idx_charge-type-id");
            $table->renameIndex("idx_accounting-type-uuid", "idx_charge-type-uuid");
            $table->renameIndex("idx_accounting-version", "idx_charge-version");
        });

        Schema::rename("accounting_types", "charge_types");
        Schema::table('charge_types', function (Blueprint $table) {
            $table->renameColumn("accounting_type_id", "charge_type_id");
            $table->renameColumn("accounting_type_uuid", "charge_type_uuid");
            $table->renameColumn("accounting_type_name", "charge_type_name");
            $table->renameColumn("accounting_type_memo", "charge_type_memo");
            $table->renameIndex("idx_accounting-type-id", "idx_charge-type-id");
            $table->renameIndex("idx_accounting-type-uuid", "idx_charge-type-uuid");
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnInSoundblockServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_services", function (Blueprint $objTable) {
            $objTable->renameColumn("accounting_rate", "accounting_version");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_services", function (Blueprint $objTable) {
            $objTable->renameColumn("accounting_version", "accounting_rate");
        });
    }
}

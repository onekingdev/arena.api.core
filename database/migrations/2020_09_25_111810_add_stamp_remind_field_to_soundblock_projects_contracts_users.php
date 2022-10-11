<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStampRemindFieldToSoundblockProjectsContractsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects_contracts_users", function (Blueprint $objTable) {
            $objTable->bigInteger("stamp_remind")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects_contracts_users", function (Blueprint $objTable) {
            $objTable->dropColumn("stamp_remind");
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIndexesInSoundblockServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_services", function (Blueprint $objTable) {
            $objTable->dropUnique("uidx_user-id");
            $objTable->dropUnique("uidx_user-uuid");
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
            $objTable->unique("user_id", "uidx_user-id");
            $objTable->unique("user_uuid", "uidx_user-uuid");
        });
    }
}

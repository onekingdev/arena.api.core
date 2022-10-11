<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppGroupToCoreAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_apps', function (Blueprint $objTable) {
            $objTable->string("app_group")->nullable()->after("app_uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('core_apps', function (Blueprint $objTable) {
            $objTable->dropColumn("app_group");
        });
    }
}

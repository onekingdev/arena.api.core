<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFieldFromCoreAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_apps', function (Blueprint $objTable) {
            $objTable->dropColumn("app_platform");
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
            $objTable->string("app_platform")->nullable();
        });
    }
}

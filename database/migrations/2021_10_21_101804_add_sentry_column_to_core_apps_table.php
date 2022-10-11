<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentryColumnToCoreAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("core_apps", function (Blueprint $objTable) {
            $objTable->string("sentry_id")->after("app_name")->nullable()->index("idx_sentry-id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("core_apps", function (Blueprint $objTable) {
            $objTable->dropColumn("sentry_id");
            $objTable->dropIndex("idx_sentry-id");
        });
    }
}

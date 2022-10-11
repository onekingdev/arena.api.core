<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeParentFieldsNullableInCoreAppsStructTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_apps_struct', function (Blueprint $table) {
            $table->unsignedBigInteger("parent_id")->nullable()->change();
            $table->uuid("parent_uuid")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('core_apps_struct', function (Blueprint $table) {
            $table->unsignedBigInteger("parent_id")->nullable(false)->change();
            $table->uuid("parent_uuid")->nullable(false)->change();
        });
    }
}

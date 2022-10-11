<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAuthFieldsNullableInAuthGroupsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("core_auth_groups", function (Blueprint $table) {
            $table->unsignedBigInteger("auth_id")->nullable()->change();
            $table->uuid("auth_uuid")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("core_auth_groups", function (Blueprint $table) {
            $table->unsignedBigInteger("auth_id")->nullable(false)->change();
            $table->uuid("auth_uuid")->nullable(false)->change();
        });
    }
}

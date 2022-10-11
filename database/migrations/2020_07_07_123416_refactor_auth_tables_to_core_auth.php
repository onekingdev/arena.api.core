<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorAuthTablesToCoreAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("auth", "core_auth");
        Schema::rename("auth_groups", "core_auth_groups");
        Schema::rename("auth_groups_users", "core_auth_groups_users");
        Schema::rename("auth_permissions", "core_auth_permissions");
        Schema::rename("auth_permissions_groups", "core_auth_permissions_groups");
        Schema::rename("auth_permissions_groups_users", "core_auth_permissions_groups_users");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("core_auth", "auth");
        Schema::rename("core_auth_groups", "auth_groups");
        Schema::rename("core_auth_groups_users", "auth_groups_users");
        Schema::rename("core_auth_permissions", "auth_permissions");
        Schema::rename("core_auth_permissions_groups", "auth_permissions_groups");
        Schema::rename("core_auth_permissions_groups_users", "auth_permissions_groups_users");
    }
}

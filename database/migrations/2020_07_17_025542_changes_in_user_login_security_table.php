<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesInUserLoginSecurityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_login_security', function (Blueprint $table) {
            $table->boolean("google2fa_enable")->default(true)->change();
            $table->renameColumn("google2fa_enable", "flag_enabled");

            $table->index("user_id", "idx_user-id");
            $table->index("user_uuid", "idx_user-uuid");
            $table->index("stamp_deleted_at", "idx_stamp-deleted-at");
            $table->index(["user_id", "stamp_deleted_at"], "idx_user-id_stamp-deleted-at");
            $table->index(["user_uuid", "stamp_deleted_at"], "idx_user-uuid_stamp-deleted-at");

            $table->unique("google2fa_secret", "uidx_google2fa-secret");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_login_security', function (Blueprint $table) {
            $table->renameColumn("flag_enabled", "google2fa_enable");
            $table->boolean("google2fa_enable")->default(false)->change();

            $table->dropIndex("idx_user-id");
            $table->dropIndex("idx_user-uuid");
            $table->dropIndex("idx_stamp-deleted-at");
            $table->dropIndex("idx_user-id_stamp-deleted-at");
            $table->dropIndex("idx_user-uuid_stamp-deleted-at");

            $table->dropUnique("uidx_google2fa-secret");
        });
    }
}

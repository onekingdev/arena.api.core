<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToCoreAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("core_auth", function (Blueprint $table) {
            $table->index("auth_id", "idx_auth-id");
            $table->index("auth_uuid", "idx_auth-uuid");
            $table->index("auth_name", "idx_auth-name");
            $table->index("stamp_deleted_at", "idx_stamp-deleted-at");

            $table->index(["auth_id", "stamp_deleted_at"], "idx_auth-id_stamp-deleted-at");
            $table->index(["auth_uuid", "stamp_deleted_at"], "idx_auth-uuid_stamp-deleted-at");
            $table->index(["auth_name", "stamp_deleted_at"], "idx_auth-name_stamp-deleted-at");
            $table->index(["app_id", "stamp_deleted_at"], "idx_app-id_stamp-deleted-at");
            $table->index(["app_uuid", "stamp_deleted_at"], "idx_app-uuid_stamp-deleted-at");

            $table->index(["auth_name", "app_id", "stamp_deleted_at"], "idx_auth-name_app-id_stamp-deleted-at");
            $table->index(["auth_name", "app_uuid", "stamp_deleted_at"], "idx_auth-name_app-uuid_stamp-deleted-at");
            $table->index(["app_id", "auth_name", "stamp_deleted_at"], "idx_app-id_auth-name_stamp-deleted-at");
            $table->index(["app_uuid", "auth_name", "stamp_deleted_at"], "idx_app-uuid_auth-name_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("core_auth", function (Blueprint $table) {
            $table->dropIndex("idx_auth-id");
            $table->dropIndex("idx_auth-uuid");
            $table->dropIndex("idx_auth-name");
            $table->dropIndex("idx_stamp-deleted-at");

            $table->dropIndex("idx_auth-id_stamp-deleted-at");
            $table->dropIndex("idx_auth-uuid_stamp-deleted-at");
            $table->dropIndex("idx_auth-name_stamp-deleted-at");
            $table->dropIndex("idx_app-id_stamp-deleted-at");
            $table->dropIndex("idx_app-uuid_stamp-deleted-at");

            $table->dropIndex("idx_auth-name_app-id_stamp-deleted-at");
            $table->dropIndex("idx_auth-name_app-uuid_stamp-deleted-at");
            $table->dropIndex("idx_app-id_auth-name_stamp-deleted-at");
            $table->dropIndex("idx_app-uuid_auth-name_stamp-deleted-at");
        });
    }
}

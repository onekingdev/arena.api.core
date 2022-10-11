<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToCoreAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("core_apps", function (Blueprint $table) {
            $table->index("app_id", "idx_app-id");
            $table->index("app_uuid", "idx_app-uuid");
            $table->index("app_name", "idx_app-name");
            $table->index("stamp_deleted_at", "idx_stamp-deleted-at");
            $table->index(["app_id", "stamp_deleted_at"], "idx_app-id_stamp-deleted-at");
            $table->index(["app_uuid", "stamp_deleted_at"], "idx_app-uuid_stamp-deleted-at");
            $table->index(["app_name", "stamp_deleted_at"], "idx_app-name_stamp-deleted-at");

            $table->unique("app_name", "uidx_app-name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("core_apps", function (Blueprint $table) {
            $table->dropIndex("idx_app-id");
            $table->dropIndex("idx_app-uuid");
            $table->dropIndex("idx_app-name");
            $table->dropIndex("idx_stamp-deleted-at");
            $table->dropIndex("idx_app-id_stamp-deleted-at");
            $table->dropIndex("idx_app-uuid_stamp-deleted-at");
            $table->dropIndex("idx_app-name_stamp-deleted-at");

            $table->dropUnique("uidx_app-name");
        });
    }
}

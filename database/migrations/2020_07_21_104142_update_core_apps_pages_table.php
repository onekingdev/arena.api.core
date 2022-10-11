<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCoreAppsPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("core_apps_pages", function (Blueprint $objTable) {
            $objTable->unsignedBigInteger("struct_id")->index("idx_struct-id")->after("app_uuid");
            $objTable->uuid("struct_uuid")->index("idx_struct-uuid")->after("struct_id");

            $objTable->json("page_json")->after("page_url");

            $objTable->unique("page_url", "uidx_page-url");
            $objTable->unique(["page_id", "struct_id"], "uidx_page-id_struct-id");
            $objTable->unique(["page_uuid", "struct_uuid"], "uidx_page-uuid_struct-uuid");

            $objTable->index(["page_id", "stamp_deleted_at"], "idx_page-id_stamp-deleted-at");
            $objTable->index(["page_url", "stamp_deleted_at"], "idx_page-url_stamp-deleted-at");
            $objTable->index(["page_uuid", "stamp_deleted_at"], "idx_page-uuid_stamp-deleted-at");
            $objTable->index(["struct_id", "stamp_deleted_at"], "idx_struct-id_stamp-deleted-at");
            $objTable->index(["struct_uuid", "stamp_deleted_at"], "idx_struct-uuid_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("core_apps_pages", function (Blueprint $objTable) {
            $objTable->dropColumn("struct_id");
            $objTable->dropColumn("page_json");
            $objTable->dropColumn("struct_uuid");

            $objTable->dropIndex("idx_page-url");
            $objTable->dropIndex("idx_page-id_struct-id");
            $objTable->dropIndex("idx_page-uuid_struct-uuid");
            $objTable->dropIndex("idx_page-id_stamp-deleted-at");
            $objTable->dropIndex("idx_page-url_stamp-deleted-at");
            $objTable->dropIndex("idx_page-uuid_stamp-deleted-at");
            $objTable->dropIndex("idx_struct-id_stamp-deleted-at");
            $objTable->dropIndex("idx_struct-uuid_stamp-deleted-at");
        });
    }
}

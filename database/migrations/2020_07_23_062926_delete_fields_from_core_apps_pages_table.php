<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFieldsFromCoreAppsPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_apps_pages', function (Blueprint $objTable) {
            $objTable->dropColumn("page_url_params");
            $objTable->dropColumn("page_title");
            $objTable->dropColumn("page_description");
            $objTable->dropColumn("page_keywords");
            $objTable->dropColumn("page_image");
            $objTable->dropColumn("app_id");
            $objTable->dropColumn("app_uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('core_apps_pages', function (Blueprint $objTable) {
            $objTable->unsignedBigInteger("app_id")->index("idx_app-id");
            $objTable->uuid("app_uuid")->index("uidx_app-uuid");
            $objTable->text("page_url_params");
            $objTable->string("page_title");
            $objTable->text("page_description");
            $objTable->string("page_keywords");
            $objTable->string("page_image");
        });
    }
}

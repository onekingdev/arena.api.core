<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagLatestToSoundblockProjectsDeployments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects_deployments", function (Blueprint $objTable) {
            $objTable->boolean("flag_latest_collection")->after("flag_notify")->default(true);
            $objTable->boolean("flag_latest_distribution")->after("flag_latest_collection")->default(true);
            $objTable->index(["flag_latest_collection", "stamp_deleted_at"], "idx_flag-latest-collection_stamp-deleted-at");
            $objTable->index(["flag_latest_distribution", "stamp_deleted_at"], "idx_flag-latest-distribution_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects_deployments", function (Blueprint $objTable) {
            $objTable->dropColumn("flag_latest_collection");
            $objTable->dropColumn("flag_latest_distribution");
            $objTable->dropIndex("idx_flag-latest-collection_stamp-deleted-at");
            $objTable->dropIndex("idx_flag-latest-distribution_stamp-deleted-at");
        });
    }
}

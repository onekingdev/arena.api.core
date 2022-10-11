<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectTypeIdColumnsToSoundblockProjectsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("soundblock_projects", function (Blueprint $table) {
            $table->unsignedBigInteger("project_type_id")->nullable()->after("project_type");
            $table->uuid("project_type_uuid")->nullable()->after("project_type_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("soundblock_projects", function (Blueprint $table) {
            $table->dropColumn("project_type_id", "project_type_uuid");
        });
    }
}

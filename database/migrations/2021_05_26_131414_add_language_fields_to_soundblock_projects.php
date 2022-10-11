<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageFieldsToSoundblockProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects", function (Blueprint $objTable) {
            $objTable->unsignedBigInteger("project_language_id")->after("artwork_name")->index("idx_project-language-id");
            $objTable->string("project_language_uuid")->after("project_language_id")->index("idx_project-language-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects", function (Blueprint $objTable) {
            $objTable->dropColumn("project_language_id");
            $objTable->dropColumn("project_language_uuid");
        });
    }
}

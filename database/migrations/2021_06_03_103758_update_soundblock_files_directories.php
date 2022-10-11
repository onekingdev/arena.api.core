<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSoundblockFilesDirectories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_files_directories", function (Blueprint $objTable){
            $objTable->dropColumn("category_id");
            $objTable->string("parent_id")->after("directory_uuid")->nullable();
            $objTable->string("directory_category")->after("parent_id")->index("idx_directory-category");
            $objTable->index("directory_sortby", "idx_directory-sortby");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_files_directories", function (Blueprint $objTable){
            $objTable->string("category_id")->nullable();

            $objTable->dropColumn("parent_id");
            $objTable->dropColumn("directory_category");
            $objTable->dropIndex("idx_directory-sortby");
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentDirectoryFieldToSoundblockFilesDirectories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_files_directories", function (Blueprint $objTable) {
            $objTable->unsignedBigInteger("directory_parent_id")->after("directory_uuid")->nullable();
            $objTable->string("directory_parent_uuid")->after("directory_parent_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_files_directories", function (Blueprint $objTable) {
            $objTable->dropColumn("directory_parent_id");
            $objTable->dropColumn("directory_parent_uuid");
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtensionFieldToSoundblockFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_files", function (Blueprint $objTable) {
            $objTable->string("file_extension", 25)->after("file_md5")->index("idx_file-extension");

            $objTable->index("file_sortby", "idx_file-sortby");

            $objTable->renameIndex("file_uuid", "uidx_file-uuid");
            $objTable->renameIndex("file_id", "uidx_file-id");
            $objTable->renameIndex("directory_id", "idx_directory-id");
            $objTable->renameIndex("directory_uuid", "idx_directory-uuid");
            $objTable->renameIndex("stamp_created", "idx_stamp-created");
            $objTable->renameIndex("stamp_deleted", "idx_stamp-deleted");
            $objTable->renameIndex("stamp_modified", "idx_stamp-modified");
            $objTable->renameIndex("stamp_updated", "idx_stamp-updated");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_files", function (Blueprint $objTable) {
            $objTable->dropColumn("file_extension");

            $objTable->dropIndex("idx_file-extension");
            $objTable->dropIndex("idx_file-sortby");

            $objTable->renameIndex("uidx_file-uuid", "file_uuid");
            $objTable->renameIndex("uidx_file-id", "file_id");
            $objTable->renameIndex("idx_directory-id", "directory_id");
            $objTable->renameIndex("idx_directory-uuid", "directory_uuid");
            $objTable->renameIndex("idx_stamp-created", "stamp_created");
            $objTable->renameIndex("idx_stamp-deleted", "stamp_deleted");
            $objTable->renameIndex("idx_stamp-modified", "stamp_modified");
            $objTable->renameIndex("idx_stamp-updated", "stamp_updated");
        });
    }
}

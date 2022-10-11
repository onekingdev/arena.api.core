<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStampModifiedFieldsFromSoundblockFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_files", function (Blueprint $objTable) {
            $objTable->dropColumn(BaseModel::STAMP_MODIFIED);
            $objTable->dropColumn(BaseModel::MODIFIED_AT);
            $objTable->dropColumn(BaseModel::STAMP_MODIFIED_BY);
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
            $objTable->unsignedBigInteger(BaseModel::STAMP_MODIFIED)->nullable()->index("idx_stamp-modified");
            $objTable->timestamp(BaseModel::MODIFIED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_MODIFIED_BY)->nullable();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvitePermissionsFieldToSoundblockInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_invites", function (Blueprint $table) {
            $table->json("invite_permissions")->after("invite_payout")->nullable();

            $table->index(["invite_hash", "stamp_deleted_at"], "idx_invite-hash_stamp-deleted-at");
            $table->index(["model_class", "model_id"], "idx_model-class_model-id");
            $table->index(["model_id", "model_class"], "idx_model-id_model-class");
            $table->index(["model_class", "stamp_deleted_at"], "idx_model-class_stamp-deleted-at");
            $table->index(["model_class", "model_id", "stamp_deleted_at"], "idx_model-class_model-id_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_invites", function (Blueprint $table) {
            $table->dropColumn("invite_permissions");

            $table->dropIndex("idx_invite-hash_stamp-deleted-at");
            $table->dropIndex("idx_model-class_model-id");
            $table->dropIndex("idx_model-id_model-class");
            $table->dropIndex("idx_model-class_stamp-deleted-at");
            $table->dropIndex("idx_model-class_model-id_stamp-deleted-at");
        });
    }
}

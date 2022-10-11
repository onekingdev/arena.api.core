<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagsToSoundblockCollectionTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("soundblock_collections", function (Blueprint $table) {
            $table->boolean("flag_changed_music")->after("project_uuid")->default(false);
            $table->boolean("flag_changed_video")->after("flag_changed_music")->default(false);
            $table->boolean("flag_changed_merchandising")->after("flag_changed_video")->default(false);
            $table->boolean("flag_changed_other")->after("flag_changed_merchandising")->default(false);

            $table->index(["flag_changed_music", "stamp_deleted_at"], "idx_flag-changed-music_stamp-deleted-at");
            $table->index(["flag_changed_video", "stamp_deleted_at"], "idx_flag-changed-video_stamp-deleted-at");
            $table->index(["flag_changed_merchandising", "stamp_deleted_at"], "idx_flag-changed-merchandising_stamp-deleted-at");
            $table->index(["flag_changed_other", "stamp_deleted_at"], "idx_flag-changed-other_stamp-deleted-at");

            $table->index(["project_id", "flag_changed_music", "stamp_deleted_at"], "idx_project-id_flag-changed-music_stamp-deleted-at");
            $table->index(["project_id", "flag_changed_video", "stamp_deleted_at"], "idx_project-id_flag-changed-video_stamp-deleted-at");
            $table->index(["project_id", "flag_changed_merchandising", "stamp_deleted_at"], "idx_project-id_flag-changed-merchandising_stamp-deleted-at");
            $table->index(["project_id", "flag_changed_other", "stamp_deleted_at"], "idx_project-id_flag-changed-other_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("soundblock_collections", function (Blueprint $table) {
            $table->dropColumn("flag_changed_music", "flag_changed_video", "flag_changed_merchandising", "flag_changed_other");

            $table->dropIndex("idx_flag-changed-music_stamp-deleted-at");
            $table->dropIndex("idx_flag-changed-video_stamp-deleted-at");
            $table->dropIndex("idx_flag-changed-merchandising_stamp-deleted-at");
            $table->dropIndex("idx_flag-changed-other_stamp-deleted-at");

            $table->dropIndex("idx_project-id_flag-changed-music_stamp-deleted-at");
            $table->dropIndex("idx_project-id_flag-changed-video_stamp-deleted-at");
            $table->dropIndex("idx_project-id_flag-changed-merchandising_stamp-deleted-at");
            $table->dropIndex("idx_project-id_flag-changed-other_stamp-deleted-at");
        });
    }
}

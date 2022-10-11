<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSoundblockProjectsBandwidthTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::rename("soundblock_projects_bandwidth", "soundblock_audit_bandwidth");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::rename("soundblock_audit_bandwidth", "soundblock_projects_bandwidth");
    }
}

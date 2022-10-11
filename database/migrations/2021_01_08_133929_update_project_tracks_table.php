<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("projects_tracks", function (Blueprint $objTable) {
            $sm = Schema::connection("mysql-music")->getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes("projects_tracks");

            if(array_key_exists("unique_id", $indexesFound)){
                $objTable->dropUnique("unique_id");
            }

            $objTable->unique(["project_id", "disc_number", "track_number", "stamp_deleted_at"], "unique_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("mysql-music")->table("projects_tracks", function (Blueprint $objTable) {
            $sm = Schema::connection("mysql-music")->getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes("projects_tracks");

            if(array_key_exists("unique_id", $indexesFound)){
                $objTable->dropUnique("unique_id");
            }

            $objTable->unique(["project_id", "disc_number", "track_number"], "unique_id");
        });
    }
}

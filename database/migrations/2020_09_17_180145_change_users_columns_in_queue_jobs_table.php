<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersColumnsInQueueJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("queue_jobs", function (Blueprint $table) {
            $table->unsignedBigInteger("user_id")->nullable()->change();
            $table->uuid("user_uuid")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("queue_jobs", function (Blueprint $table) {
            $table->unsignedBigInteger("user_id")->nullable(false)->change();
            $table->uuid("user_uuid")->nullable(false)->change();
        });
    }
}

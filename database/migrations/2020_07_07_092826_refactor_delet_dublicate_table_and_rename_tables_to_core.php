<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorDeletDublicateTableAndRenameTablesToCore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('apps_jobfailures');
        Schema::rename("apps_failed_jobs", "core_jobs_failures");
        Schema::rename("apps", "core_apps");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps_jobfailures');
        Schema::create('apps_jobfailures', function (Blueprint $objTable) {
            $objTable->bigIncrements('id');
            $objTable->text('connection');
            $objTable->text('queue');
            $objTable->longText('payload');
            $objTable->longText('exception');
            $objTable->timestamp('failed_at')->useCurrent();

            $objTable->unique("id", "uidx_id");
        });
        Schema::rename("core_jobs_failures", "apps_failed_jobs");
        Schema::rename("core_apps", "apps");
    }
}

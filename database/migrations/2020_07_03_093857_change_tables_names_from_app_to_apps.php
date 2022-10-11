<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTablesNamesFromAppToApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("app_failed_jobs", "apps_failed_jobs");
        Schema::rename("app_jobfailures", "apps_jobfailures");
        Schema::rename("common_apps", "apps");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("apps_failed_jobs", "app_failed_jobs");
        Schema::rename("apps_jobfailures", "app_jobfailures");
        Schema::rename("apps", "common_apps");
    }
}

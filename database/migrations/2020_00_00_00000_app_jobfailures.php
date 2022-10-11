<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppJobfailures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_jobfailures', function (Blueprint $objTable) {
            $objTable->bigIncrements('id');
            $objTable->text('connection');
            $objTable->text('queue');
            $objTable->longText('payload');
            $objTable->longText('exception');
            $objTable->timestamp('failed_at')->useCurrent();

            $objTable->unique("id", "uidx_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_jobfailures');
    }
}

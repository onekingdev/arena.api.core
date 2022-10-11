<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropApparelProductsStylesImagesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $styleImagesMigration = new CreateApparelProductsStylesImagesTable();
        $styleImagesMigration->down();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        $styleImagesMigration = new CreateApparelProductsStylesImagesTable();
        $styleImagesMigration->up();
    }
}

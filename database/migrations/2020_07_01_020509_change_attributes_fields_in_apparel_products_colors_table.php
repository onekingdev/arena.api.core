<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAttributesFieldsInApparelProductsColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apparel_products_colors', function (Blueprint $table) {
            $table->unsignedBigInteger("attribute_id")->nullable()->change();
            $table->uuid("attribute_uuid")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apparel_products_colors', function (Blueprint $table) {
            $table->unsignedBigInteger("attribute_id")->nullable(false)->change();
            $table->uuid("attribute_uuid")->nullable(false)->change();
        });
    }
}

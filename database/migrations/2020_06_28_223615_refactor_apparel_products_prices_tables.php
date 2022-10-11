<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorApparelProductsPricesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("apparel_products_prices", function (Blueprint $table) {
            $table->dropColumn("product_price_range");

            $table->unsignedMediumInteger("range_min")->after("product_price");
            $table->unsignedMediumInteger("range_max")->after("range_min");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("apparel_products_prices", function (Blueprint $table) {
            $table->dropColumn(["range_min", "range_max"]);

            $table->string("product_price_range")->after("product_price");
        });
    }
}

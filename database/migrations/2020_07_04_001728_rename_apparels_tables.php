<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameApparelsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::rename("apparel_attributes", "merch_apparel_attributes");
        Schema::rename("apparel_categories", "merch_apparel_categories");
        Schema::rename("apparel_files", "merch_apparel_files");
        Schema::rename("apparel_products", "merch_apparel_products");
        Schema::rename("apparel_products_attributes", "merch_apparel_products_attributes");
        Schema::rename("apparel_products_colors", "merch_apparel_products_colors");
        Schema::rename("apparel_products_files", "merch_apparel_products_files");
        Schema::rename("apparel_products_prices", "merch_apparel_products_prices");
        Schema::rename("apparel_products_related", "merch_apparel_products_related");
        Schema::rename("apparel_products_sizes", "merch_apparel_products_sizes");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("merch_apparel_attributes", "apparel_attributes");
        Schema::rename("merch_apparel_categories", "apparel_categories");
        Schema::rename("merch_apparel_files", "apparel_files");
        Schema::rename("merch_apparel_products", "apparel_products");
        Schema::rename("merch_apparel_products_attributes", "apparel_products_attributes");
        Schema::rename("merch_apparel_products_colors", "apparel_products_colors");
        Schema::rename("merch_apparel_products_files", "apparel_products_files");
        Schema::rename("merch_apparel_products_prices", "apparel_products_prices");
        Schema::rename("merch_apparel_products_related", "apparel_products_related");
        Schema::rename("merch_apparel_products_sizes", "apparel_products_sizes");
    }
}

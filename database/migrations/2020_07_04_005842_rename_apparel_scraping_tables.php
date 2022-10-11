<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameApparelScrapingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("apparel_scraping_categories", "x_scraping_apparel_categories");
        Schema::rename("apparel_scraping_categories_products", "x_scraping_apparel_categories_products");
        Schema::rename("apparel_scraping_colors", "x_scraping_apparel_colors");
        Schema::rename("apparel_scraping_colors_groups", "x_scraping_apparel_colors_groups");
        Schema::rename("apparel_scraping_files", "x_scraping_apparel_files");
        Schema::rename("apparel_scraping_products", "x_scraping_apparel_products");
        Schema::rename("apparel_scraping_products_colors", "x_scraping_apparel_products_colors");
        Schema::rename("apparel_scraping_products_files", "x_scraping_apparel_products_files");
        Schema::rename("apparel_scraping_products_prices", "x_scraping_apparel_products_prices");
        Schema::rename("apparel_scraping_products_related", "x_scraping_apparel_products_related");
        Schema::rename("apparel_scraping_products_sizes", "x_scraping_apparel_products_sizes");
        Schema::rename("apparel_scraping_products_styles", "x_scraping_apparel_products_styles");
        Schema::rename("apparel_scraping_product_weight", "x_scraping_apparel_products_weight");
        Schema::rename("apparel_scraping_products_styles_images", "x_scraping_apparel_products_styles_images");
        Schema::rename("apparel_scraping_sizes", "x_scraping_apparel_sizes");
        Schema::rename("apparel_scraping_styles", "x_scraping_apparel_styles");
        Schema::rename("apparel_scraping_weight", "x_scraping_apparel_weight");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("x_scraping_apparel_categories", "apparel_scraping_categories");
        Schema::rename("x_scraping_apparel_categories_products", "apparel_scraping_categories_products");
        Schema::rename("x_scraping_apparel_colors", "apparel_scraping_colors");
        Schema::rename("x_scraping_apparel_colors_groups", "apparel_scraping_colors_groups");
        Schema::rename("x_scraping_apparel_files", "apparel_scraping_files");
        Schema::rename("x_scraping_apparel_product_weight", "apparel_scraping_product_weight");
        Schema::rename("x_scraping_apparel_products", "apparel_scraping_products");
        Schema::rename("x_scraping_apparel_products_colors", "apparel_scraping_products_colors");
        Schema::rename("x_scraping_apparel_products_files", "apparel_scraping_products_files");
        Schema::rename("x_scraping_apparel_products_prices", "apparel_scraping_products_prices");
        Schema::rename("x_scraping_apparel_products_related", "apparel_scraping_products_related");
        Schema::rename("x_scraping_apparel_products_sizes", "apparel_scraping_products_sizes");
        Schema::rename("x_scraping_apparel_products_styles", "apparel_scraping_products_styles");
        Schema::rename("x_scraping_apparel_products_styles_images", "apparel_scraping_products_styles_images");
        Schema::rename("x_scraping_apparel_sizes", "apparel_scraping_sizes");
        Schema::rename("x_scraping_apparel_styles", "apparel_scraping_styles");
        Schema::rename("x_scraping_apparel_weight", "apparel_scraping_weight");
    }
}

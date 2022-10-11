<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptimizeApparelProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("apparel_products", function (Blueprint $table) {
            $table->dropColumn("ascolour_ref");
            $table->dropColumn("product_url");
            $table->dropColumn("product_html");
            $table->dropColumn("product_price");

            $table->string("ascolour_id", 5)->after("product_uuid");
            $table->text("product_meta_description")->nullable()->after("product_description");
            $table->string("product_meta_keywords")->nullable()->after("product_meta_description");
            $table->unsignedTinyInteger("product_weight")->after("product_meta_keywords");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("apparel_products", function (Blueprint $table) {
            $table->unsignedBigInteger('ascolour_ref');
            $table->string('product_url');
//            $table->float("product_price");

            $table->dropColumn(["ascolour_id", "product_meta_description", "product_meta_keywords", "product_weight"]);
        });

        DB::statement("ALTER TABLE apparel_products ADD product_html LONGBLOB");
    }
}

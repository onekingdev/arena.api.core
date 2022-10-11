<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptimizeApparelsTables extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("apparel_attributes", function (Blueprint $table) {
            $table->dropIndex("idx_preview-id");
            $table->dropIndex("idx_preview-uuid");
            $table->dropColumn("preview_id");
            $table->dropColumn("preview_uuid");

            $table->index([
                "category_uuid", "attribute_uuid", "attribute_type", "stamp_deleted_at"
            ], "idx_category-uuid_attribute-uuid_attribute-type_stamp-deleted-at");

            $table->index(["category_id", "stamp_deleted_at"], "idx_category-id_stamp-deleted-at");
            $table->index(["category_uuid", "stamp_deleted_at"], "idx_category-uuid_stamp-deleted-at");
            $table->index(["attribute_id", "stamp_deleted_at"], "idx_attribute-id_stamp-deleted-at");
            $table->index(["attribute_uuid", "stamp_deleted_at"], "idx_attribute-uuid_stamp-deleted-at");
        });

        Schema::table("apparel_files", function (Blueprint $table) {
            $table->dropColumn("file_url");

            $table->index(["file_id", "stamp_deleted_at"], "idx_file-id_stamp-deleted-at");
            $table->index(["file_uuid", "stamp_deleted_at"], "idx_file-uuid_stamp-deleted-at");
        });

        Schema::table("apparel_products", function (Blueprint $table) {
            $table->index(["product_id", "stamp_deleted_at"], "idx_product-id_stamp-deleted-at");
            $table->index(["product_uuid", "stamp_deleted_at"], "idx_product-uuid_stamp-deleted-at");
            $table->index("product_name", "idx_product-name");
            $table->index("product_weight", "idx_product-weight");
        });

        Schema::table("apparel_products_attributes", function (Blueprint $table) {
            $table->index(["product_id", "attribute_id"], "idx_product-id_attribute-id");
            $table->index(["product_id", "attribute_id", "stamp_deleted_at"], "idx_product-id_attribute-id_stamp-deleted-at");

            $table->index(["product_uuid", "attribute_uuid"], "idx_product-uuid_attribute-uuid");
            $table->index(["product_uuid", "attribute_uuid", "stamp_deleted_at"], "idx_product-uuid_attribute-uuid_stamp-deleted-at");

            $table->index(["attribute_id", "product_id"], "idx_attribute-id_product-id");
            $table->index(["attribute_id", "product_id", "stamp_deleted_at"], "idx_attribute-id_product-id_stamp-deleted-at");

            $table->index(["attribute_uuid", "product_uuid"], "idx_attribute-uuid_product-uuid");
            $table->index(["attribute_uuid", "product_uuid", "stamp_deleted_at"], "idx_attribute-uuid_product-uuid_stamp-deleted-at");

            $table->index(["attribute_id", "stamp_deleted_at"], "idx_attribute-id_stamp-deleted-at");
            $table->index(["attribute_uuid", "stamp_deleted_at"], "idx_attribute-uuid_stamp-deleted-at");

            $table->index(["product_id", "stamp_deleted_at"], "idx_product-id_stamp-deleted-at");
            $table->index(["product_uuid", "stamp_deleted_at"], "idx_product-uuid_stamp-deleted-at");
        });

        Schema::table("apparel_products_colors", function (Blueprint $table) {
            $table->index(["attribute_id", "stamp_deleted_at"], "idx_attribute-id_stamp-deleted-at");
            $table->index(["attribute_uuid", "stamp_deleted_at"], "idx_attribute-uuid_stamp-deleted-at");

            $table->index(["product_id", "stamp_deleted_at"], "idx_product-id_stamp-deleted-at");
            $table->index(["product_uuid", "stamp_deleted_at"], "idx_product-uuid_stamp-deleted-at");

            $table->unique(["product_id", "color_name"], "uidx_product-id_color-name");
            $table->unique(["color_name", "product_id"], "uidx_color-name_product-id");

            $table->unique(["product_uuid", "color_name"], "uidx_product-uuid_color-name");
            $table->unique(["color_name", "product_uuid"], "uidx_color-name_product-uuid");
        });

        Schema::table("apparel_products_files", function (Blueprint $table) {
            $table->index(["product_id", "stamp_deleted_at"], "idx_product-id_stamp-deleted-at");
            $table->index(["product_uuid", "stamp_deleted_at"], "idx_product-uuid_stamp-deleted-at");

            $table->index(["color_id", "stamp_deleted_at"], "idx_color-id_stamp-deleted-at");
            $table->index(["color_uuid", "stamp_deleted_at"], "idx_color-uuid_stamp-deleted-at");

            $table->index(["product_id", "color_id", "stamp_deleted_at"], "idx_product-id_color-id_stamp-deleted-at");
            $table->index(["product_uuid", "color_uuid", "stamp_deleted_at"], "idx_product-uuid_color-uuid_stamp-deleted-at");

            $table->index(["product_id", "file_type", "stamp_deleted_at"], "idx_product-id_file-type_stamp-deleted-at");
            $table->index(["product_uuid", "file_type", "stamp_deleted_at"], "idx_product-uuid_file-type_stamp-deleted-at");

            $table->index(["color_id", "file_type", "stamp_deleted_at"], "idx_color-id_file-type_stamp-deleted-at");
            $table->index(["color_uuid", "file_type", "stamp_deleted_at"], "idx_color-uuid_file-type_stamp-deleted-at");

            $table->index(["product_id", "color_id", "file_type", "stamp_deleted_at"], "idx_product-id_color-id_file-type_stamp-deleted-at");
            $table->index(["product_uuid", "color_uuid", "file_type", "stamp_deleted_at"], "idx_product-uuid_color-uuid_file-type_stamp-deleted-at");

            $table->index(["color_id", "product_id",  "file_type", "stamp_deleted_at"], "idx_color-id_product-id_file-type_stamp-deleted-at");
            $table->index(["color_uuid", "product_uuid", "file_type", "stamp_deleted_at"], "idx_color-uuid_product-uuid_file-type_stamp-deleted-at");
        });

        Schema::table("apparel_products_prices", function (Blueprint $table) {
            $table->index("range_min", "idx_range-min");
            $table->index("range_max", "idx_range-max");
            $table->index(["range_min", "range_max"], "idx_range-min_range-max");

            $table->index(["range_min", "stamp_deleted_at"], "idx_range-min_stamp-deleted-at");
            $table->index(["range_max", "stamp_deleted_at"], "idx_range-max_stamp-deleted-at");
            $table->index(["range_min", "range_max", "stamp_deleted_at"], "idx_range-min_range-max_stamp-deleted-at");

            $table->index(["product_id", "range_min", "stamp_deleted_at"], "idx_product-id_range-min_stamp-deleted-at");
            $table->index(["product_id", "range_max", "stamp_deleted_at"], "idx_product-id_range-max_stamp-deleted-at");
            $table->index(["product_id", "range_min", "range_max", "stamp_deleted_at"], "idx_product-id_range-min_range-max_stamp-deleted-at");

            $table->index(["product_uuid", "range_min", "stamp_deleted_at"], "idx_product-uuid_range-min_stamp-deleted-at");
            $table->index(["product_uuid", "range_max", "stamp_deleted_at"], "idx_product-uuid_range-max_stamp-deleted-at");
            $table->index(["product_uuid", "range_min", "range_max", "stamp_deleted_at"], "idx_product-uuid_range-min_range-max_stamp-deleted-at");
        });

        Schema::table("apparel_products_related", function (Blueprint $table) {
            $table->index(["product_id", "related_id"], "idx_product-id_related-id");
            $table->index(["product_uuid", "related_uuid"], "idx_product-uuid_related-uuid");

            $table->index(["product_id", "related_id", "stamp_deleted_at"], "idx_product-id_related-id_stamp-deleted-at");
            $table->index(["product_uuid", "related_uuid", "stamp_deleted_at"], "idx_product-uuid_related-uuid_stamp-deleted-at");

            $table->unique(["product_id", "related_id"], "uidx_product-id_related-id");
            $table->unique(["product_uuid", "related_uuid"], "uidx_product-uuid_related-uuid");
        });

        Schema::table("apparel_products_sizes", function (Blueprint $table) {
            $table->index(["product_id", "size_name"], "idx_product-id_size-name");
            $table->index(["product_uuid", "size_name"], "idx_product-uuid_size-name");

            $table->index(["product_id", "size_name", "stamp_deleted_at"], "idx_product-id_size-name_stamp-deleted-at");
            $table->index(["product_uuid", "size_name", "stamp_deleted_at"], "idx_product-uuid_size-name_stamp-deleted-at");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("apparel_attributes", function (Blueprint $table) {
            $table->unsignedBigInteger("preview_id")->index("idx_preview-id");
            $table->uuid("preview_uuid")->index("idx_preview-uuid");

            $table->dropIndex("idx_category-uuid_attribute-uuid_attribute-type_stamp-deleted-at");
            $table->dropIndex("idx_category-id_stamp-deleted-at");
            $table->dropIndex("idx_category-uuid_stamp-deleted-at");
            $table->dropIndex("idx_attribute-id_stamp-deleted-at");
            $table->dropIndex("idx_attribute-uuid_stamp-deleted-at");
        });

        Schema::table("apparel_files", function (Blueprint $table) {
            $table->string("file_url")->after("file_uuid");

            $table->dropIndex("idx_file-id_stamp-deleted-at");
            $table->dropIndex("idx_file-uuid_stamp-deleted-at");
        });

        Schema::table("apparel_products", function (Blueprint $table) {
            $table->dropIndex("idx_product-id_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_stamp-deleted-at");
            $table->dropIndex("idx_product-name");
            $table->dropIndex("idx_product-weight");
        });

        Schema::table("apparel_products_attributes", function (Blueprint $table) {
            $table->dropIndex("idx_product-id_attribute-id");
            $table->dropIndex("idx_product-id_attribute-id_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_attribute-uuid");
            $table->dropIndex("idx_product-uuid_attribute-uuid_stamp-deleted-at");
            $table->dropIndex("idx_attribute-id_product-id");
            $table->dropIndex("idx_attribute-id_product-id_stamp-deleted-at");
            $table->dropIndex("idx_attribute-uuid_product-uuid");
            $table->dropIndex("idx_attribute-uuid_product-uuid_stamp-deleted-at");
            $table->dropIndex("idx_attribute-id_stamp-deleted-at");
            $table->dropIndex("idx_attribute-uuid_stamp-deleted-at");
            $table->dropIndex("idx_product-id_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_stamp-deleted-at");
        });

        Schema::table("apparel_products_colors", function (Blueprint $table) {
            $table->dropIndex("idx_attribute-id_stamp-deleted-at");
            $table->dropIndex("idx_attribute-uuid_stamp-deleted-at");
            $table->dropIndex("idx_product-id_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_stamp-deleted-at");
            $table->dropIndex("uidx_product-id_color-name");
            $table->dropIndex("uidx_color-name_product-id");
            $table->dropIndex("uidx_product-uuid_color-name");
            $table->dropIndex("uidx_color-name_product-uuid");
        });

        Schema::table("apparel_products_files", function (Blueprint $table) {
            $table->dropIndex("idx_product-id_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_stamp-deleted-at");
            $table->dropIndex("idx_color-id_stamp-deleted-at");
            $table->dropIndex("idx_color-uuid_stamp-deleted-at");
            $table->dropIndex("idx_product-id_color-id_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_color-uuid_stamp-deleted-at");
            $table->dropIndex("idx_product-id_file-type_stamp-deleted-at");

            $table->dropIndex("idx_product-uuid_file-type_stamp-deleted-at");
            $table->dropIndex("idx_color-id_file-type_stamp-deleted-at");
            $table->dropIndex("idx_color-uuid_file-type_stamp-deleted-at");
            $table->dropIndex("idx_product-id_color-id_file-type_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_color-uuid_file-type_stamp-deleted-at");
            $table->dropIndex("idx_color-id_product-id_file-type_stamp-deleted-at");
            $table->dropIndex("idx_color-uuid_product-uuid_file-type_stamp-deleted-at");
        });

        Schema::table("apparel_products_prices", function (Blueprint $table) {
            $table->dropIndex("idx_range-min");
            $table->dropIndex("idx_range-max");
            $table->dropIndex("idx_range-min_range-max");
            $table->dropIndex("idx_range-min_stamp-deleted-at");
            $table->dropIndex("idx_range-max_stamp-deleted-at");
            $table->dropIndex("idx_range-min_range-max_stamp-deleted-at");
            $table->dropIndex("idx_product-id_range-min_stamp-deleted-at");
            $table->dropIndex("idx_product-id_range-max_stamp-deleted-at");
            $table->dropIndex("idx_product-id_range-min_range-max_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_range-max_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_range-min_range-max_stamp-deleted-at");
        });

        Schema::table("apparel_products_related", function (Blueprint $table) {
            $table->dropIndex("idx_product-id_related-id");
            $table->dropIndex("idx_product-uuid_related-uuid");
            $table->dropIndex("idx_product-id_related-id_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_related-uuid_stamp-deleted-at");
            $table->dropIndex("uidx_product-id_related-id");
            $table->dropIndex("uidx_product-uuid_related-uuid");
        });

        Schema::table("apparel_products_sizes", function (Blueprint $table) {
            $table->dropIndex("idx_product-id_size-name");
            $table->dropIndex("idx_product-uuid_size-name");
            $table->dropIndex("idx_product-id_size-name_stamp-deleted-at");
            $table->dropIndex("idx_product-uuid_size-name_stamp-deleted-at");
        });
    }
}

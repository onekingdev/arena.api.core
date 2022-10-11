<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorApparelProductStylesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::rename("apparel_products_styles", "apparel_products_colors");

        Schema::table("apparel_products_colors", function (Blueprint $table) {
            $table->dropColumn([
                "ascolour_ref", "image_id", "image_uuid", "thumbnail_id", "thumbnail_uuid", "preview_id", "preview_uuid"
            ]);

            $table->renameColumn("style_name", "color_name");
            $table->unsignedBigInteger("attribute_id")->after("product_uuid");
            $table->uuid("attribute_uuid")->after("attribute_id");
            $table->json("color_hash")->after("style_name");

            $table->dropIndex("uidx_row-id_image-id");
            $table->dropIndex("uidx_row-uuid_image-uuid");
            $table->dropIndex("uidx_image-id_row-id");
            $table->dropIndex("uidx_image-uuid_row-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table("apparel_products_colors", function (Blueprint $table) {
            $table->renameColumn("color_name", "style_name");
            $table->dropColumn(["color_hash", "attribute_id", "attribute_uuid"]);

            $table->unsignedBigInteger("ascolour_ref")->after("product_uuid");

            $table->unsignedBigInteger("image_id")->after("color_name")->nullable()->index("idx_image-id");
            $table->uuid("image_uuid")->after("image_id")->nullable()->index("idx_image-uuid");
            $table->unsignedBigInteger("thumbnail_id")->after("image_uuid")->nullable()->index("idx_thumbnail-id");
            $table->uuid("thumbnail_uuid")->after("thumbnail_id")->nullable()->index("idx_thumbnail-uuid");

            $table->unsignedBigInteger("preview_id")->nullable()->index("idx_preview-id");
            $table->uuid("preview_uuid")->nullable()->index("idx_preview-uuid");

            $table->unique(["row_id", "image_id"], "uidx_row-id_image-id");
            $table->unique(["row_uuid", "image_uuid"], "uidx_row-uuid_image-uuid");
            $table->unique(["image_id", "row_id"], "uidx_image-id_row-id");
            $table->unique(["product_uuid", "image_uuid"], "uidx_image-uuid_row-uuid");
        });

        Schema::rename("apparel_products_colors", "apparel_products_styles");


    }
}

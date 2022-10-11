<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorCardToCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("core_shopping_cards", "core_shopping_carts");
        Schema::rename("core_card_items", "core_cart_items");
        Schema::table("core_cart_items", function (Blueprint $objTable) {
            $objTable->renameColumn("card_id", "cart_id");
            $objTable->renameColumn("card_uuid", "cart_uuid");
            $objTable->renameIndex("idx_card-id", "idx_cart-id");
            $objTable->renameIndex("idx_card-uuid", "idx_cart-uuid");
            $objTable->renameIndex("idx_row-id_card-id", "idx_row-id_cart-id");
            $objTable->renameIndex("idx_row-uuid_card-uuid", "idx_row-uuid_cart-uuid");
            $objTable->renameIndex("idx_card-id_stamp-deleted-at", "idx_cart-id_stamp-deleted-at");
            $objTable->renameIndex("idx_card-uuid_stamp-deleted-at", "idx_cart-uuid_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("core_shopping_carts", "core_shopping_cards");
        Schema::rename("core_cart_items", "core_card_items");
        Schema::table("core_card_items", function (Blueprint $objTable) {
            $objTable->renameColumn("cart_id", "card_id");
            $objTable->renameColumn("cart_uuid", "card_uuid");
            $objTable->renameIndex("idx_cart-id", "idx_card-id");
            $objTable->renameIndex("idx_cart-uuid", "idx_card-uuid");
            $objTable->renameIndex("idx_row-id_cart-id", "idx_row-id_card-id");
            $objTable->renameIndex("idx_row-uuid_cart-uuid", "idx_row-uuid_card-uuid");
            $objTable->renameIndex("idx_cart-id_stamp-deleted-at", "idx_card-id_stamp-deleted-at");
            $objTable->renameIndex("idx_cart-uuid_stamp-deleted-at", "idx_card-uuid_stamp-deleted-at");
        });
    }
}

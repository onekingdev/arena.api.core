<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCoreShoppingCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("core_shopping_cards", function (Blueprint $objTable) {
            $objTable->dropColumn("flag_active");
            $objTable->string("payment_id")->after("user_ip")->nullable();
            $objTable->string("payment_method")->after("payment_id")->nullable();
            $objTable->string("status")->after("payment_method");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("core_shopping_cards", function (Blueprint $objTable) {
            $objTable->dropColumn("payment_id");
            $objTable->dropColumn("payment_method");
            $objTable->dropColumn("status");
            $objTable->boolean("flag_active")->default(false);
        });
    }
}

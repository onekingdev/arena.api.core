<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInvoiceCouponColumnTypeInAccountingInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("accounting_invoices", function (Blueprint $table) {
            $table->string("invoice_coupon")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("accounting_invoices", function (Blueprint $table) {
            $table->unsignedBigInteger("invoice_coupon")->change();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersFinanceTablesNameToUsersAccounting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("users_financial_paypal", "users_accounting_paypal");
        Schema::rename("users_financial_banking", "users_accounting_banking");
        Schema::rename("users_financial_stripe", "users_accounting_stripe");
        Schema::rename("users_financial_stripe_subscriptions", "users_accounting_stripe_subscriptions");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("users_accounting_paypal", "users_financial_paypal");
        Schema::rename("users_accounting_banking", "users_financial_banking");
        Schema::rename("users_accounting_stripe", "users_financial_stripe");
        Schema::rename("users_accounting_stripe_subscriptions", "users_financial_stripe_subscriptions");
    }
}

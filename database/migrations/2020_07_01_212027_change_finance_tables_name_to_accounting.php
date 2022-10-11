<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFinanceTablesNameToAccounting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("finance_invoices", "accounting_invoices");
        Schema::rename("finance_invoices_transactions", "accounting_invoices_transactions");
        Schema::rename("finance_types_transactions", "accounting_types_transactions");
        Schema::rename("finance_types_invoices", "accounting_types_invoices");
        Schema::rename("finance_transactions_log", "accounting_transactions_log");
        Schema::rename("finance_transactions", "accounting_transactions");
        Schema::rename("finance_invoices_payments", "accounting_invoices_payments");
        Schema::rename("finance_invoices_notes", "accounting_invoices_notes");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("accounting_invoices", "finance_invoices");
        Schema::rename("accounting_invoices_transactions", "finance_invoices_transactions");
        Schema::rename("accounting_types_transactions", "finance_types_transactions");
        Schema::rename("accounting_types_invoices", "finance_types_invoices");
        Schema::rename("accounting_transactions_log", "finance_transactions_log");
        Schema::rename("accounting_transactions", "finance_transactions");
        Schema::rename("accounting_invoices_payments", "finance_invoices_payments");
        Schema::rename("accounting_invoices_notes", "finance_invoices_notes");
    }
}

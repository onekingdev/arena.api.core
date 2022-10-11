<?php

namespace App\Contracts\Accounting;

use Illuminate\Database\Eloquent\Model;
use App\Models\Accounting\{AccountingInvoice, AccountingInvoiceTransaction};

interface InvoiceTransaction
{
    public function create(AccountingInvoice $objInvoice, Model $instance, array $arrOptions) : AccountingInvoiceTransaction;
}

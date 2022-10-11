<?php

namespace App\Services\Accounting;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Accounting\InvoiceTransaction as InvoiceTransactionContract;
use App\Repositories\Accounting\AccountingInvoiceTransaction as AccountingInvoiceTransactionRepository;
use App\Models\{
    Users\User,
    Accounting\AccountingInvoice,
    Accounting\AccountingInvoiceTransaction as AccountingInvoiceTransactionModel
};

class InvoiceTransaction implements InvoiceTransactionContract {

    /** @var AccountingInvoiceTransactionRepository */
    protected AccountingInvoiceTransactionRepository $invoiceTransactionRepo;

    /**
     * @param AccountingInvoiceTransactionRepository $invoiceTransactionRepo
     */
    public function __construct(AccountingInvoiceTransactionRepository $invoiceTransactionRepo) {
        $this->invoiceTransactionRepo = $invoiceTransactionRepo;
    }

    /**
     * @param AccountingInvoice $objInvoice
     * @param Model $instance
     * @param array $arrOptions
     * @param User|null $objOfficeUser
     * @return AccountingInvoiceTransactionModel
     * @throws \Exception
     */
    public function create(AccountingInvoice $objInvoice, Model $instance, array $arrOptions, ?User $objOfficeUser = null): AccountingInvoiceTransactionModel {
        return ($this->invoiceTransactionRepo->createTransaction($objInvoice, $instance, $arrOptions, $objOfficeUser));
    }
}

<?php

namespace App\Listeners\Accounting;

use App\Services\Accounting\InvoiceTransaction;

class CreateTransaction {
    /**
     * @param InvoiceTransaction
     */
    protected InvoiceTransaction $transactionService;

    /**
     * Create the event listener.
     * @param InvoiceTransaction $transactionService
     * @return void
     */
    public function __construct(InvoiceTransaction $transactionService) {
        $this->transactionService = $transactionService;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\Accounting\CreateTransaction $event
     * @return void
     */
    public function handle($event) {
        $this->transactionService->create($event->objInvoice, $event->instance, $event->arrOptions, $event->objOfficeUser);
    }
}

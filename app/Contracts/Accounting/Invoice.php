<?php

namespace App\Contracts\Accounting;

use App\Models\{
    Accounting\AccountingTransactionType,
    Core\App,
    Users\User,
    Accounting\AccountingInvoice,
    Accounting\AccountingInvoiceType};
use Stripe\Coupon as StripeCoupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Stripe\InvoiceItem as StripeInvoiceItem;

interface Invoice
{
    public function findAll(array $options = [], ?int $perPage = null);
    public function getUserInvoices(string $user_uuid, int $per_page);
    public function getInvoiceByUuid(string $strInvoiceUUID): AccountingInvoice;
    public function getInvoiceTypes(): Collection;
    public function findInvoiceType($id, bool $bnFailure = true): AccountingInvoiceType;
    public function createInvoiceType(array $requestData);
    public function updateInvoiceType(array $requestData, string $typeUuid);
    public function deleteInvoiceType(string $typeUuid);
}

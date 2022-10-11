<?php

namespace App\Services\Accounting;

use Util;
use Exception;
use Illuminate\Support\Collection;
use Stripe\Coupon as StripeCoupon;
use Illuminate\Database\Eloquent\Model;
use Stripe\InvoiceItem as StripeInvoiceItem;
use App\Models\Accounting\AccountingTransactionType;
use App\Contracts\Accounting\Invoice as InvoiceContract;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use App\Repositories\Accounting\{
    AccountingType as AccountingTypeRepository,
    AccountingInvoice as AccountingInvoiceRepository,
    AccountingInvoiceTransaction,
    AccountingInvoiceType as AccountingInvoiceTypeRepository,
    AccountingTransactionType as AccountingTransactionTypeRepository
};
use App\Models\{Core\App, Users\User, Accounting\AccountingInvoice as AccountingInvoiceModel, Accounting\AccountingInvoiceType};

class Invoice implements InvoiceContract {

    /** @var AccountingInvoiceRepository */
    protected AccountingInvoiceRepository $invoiceRepo;
    /** @var AccountingInvoiceTypeRepository */
    protected AccountingInvoiceTypeRepository $invoiceTypeRepo;
    /** @var AccountingInvoiceTransaction */
    protected AccountingInvoiceTransaction $invoiceTransactionRepo;
    /** @var AccountingTransactionTypeRepository */
    protected AccountingTransactionTypeRepository $transactionTypeRepo;
    /** @var AccountingTypeRepository */
    protected AccountingTypeRepository $accountingTypeRepo;

    /**
     * @param AccountingInvoiceRepository $invoiceRepo
     * @param AccountingInvoiceTypeRepository $invoiceTypeRepo
     * @param AccountingInvoiceTransaction $invoiceTransactionRepo
     * @param AccountingTransactionTypeRepository $transactionTypeRepo
     * @param AccountingTypeRepository $accountingType
     */
    public function __construct(AccountingInvoiceRepository $invoiceRepo, AccountingInvoiceTypeRepository $invoiceTypeRepo,
                                AccountingInvoiceTransaction $invoiceTransactionRepo, AccountingTransactionTypeRepository $transactionTypeRepo,
                                AccountingTypeRepository $accountingType) {
        $this->invoiceRepo = $invoiceRepo;
        $this->invoiceTypeRepo = $invoiceTypeRepo;
        $this->invoiceTransactionRepo = $invoiceTransactionRepo;
        $this->transactionTypeRepo = $transactionTypeRepo;
        $this->accountingTypeRepo = $accountingType;
    }

    /**
     * @param array $options
     * @param int|null $perPage
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\Paginator
     */
    public function findAll(array $options = [], ?int $perPage = null)
    {
        return ($this->invoiceRepo->findAll($options, $perPage));
    }

    /**
     * @param string $user_uuid
     * @param int $per_page
     * @return mixed
     */
    public function getUserInvoices(string $user_uuid, int $per_page){
        $objInvoices = $this->invoiceRepo->getUserInvoices($user_uuid, $per_page);

        return ($objInvoices);
    }

    /**
     * @param string $strInvoiceUUID
     * @return mixed
     * @throws \Exception
     */
    public function getInvoiceByUuid(string $strInvoiceUUID): AccountingInvoiceModel{
        $objInvoice = $this->invoiceRepo->getInvoiceByUuid($strInvoiceUUID);

        if (is_null($objInvoice)) {
            throw new \Exception("Invoice doesn't exist.",404);
        }

        return ($objInvoice);
    }

    /**
     * @return EloquentCollection
     */
    public function getInvoiceTypes(): EloquentCollection {
        return ($this->invoiceTypeRepo->all());
    }

    /**
     * @param mixed $id
     * @param bool $bnFailure
     *
     * @return AccountingInvoiceType
     * @throws Exception
     */
    public function findInvoiceType($id, bool $bnFailure = true): AccountingInvoiceType {
        $objInvoiceType = $this->invoiceTypeRepo->find($id, $bnFailure);

        if(is_null($objInvoiceType)){
            abort(404, "Invoice type not found.");
        }

        return ($objInvoiceType);
    }

    /**
     * @param array $requestData
     * @return mixed
     * @throws Exception
     */
    public function createInvoiceType(array $requestData){
        $requestData["accounting_type_uuid"] = Util::uuid();
        $objInvoiceType = $this->accountingTypeRepo->addNewType($requestData);

        if(is_null($objInvoiceType)){
            abort(404, "Invoice type hasn't created.");
        }

        return ($objInvoiceType);
    }

    /**
     * @param array $requestData
     * @param string $typeUuid
     * @return mixed
     */
    public function updateInvoiceType(array $requestData, string $typeUuid){
        $boolResult = $this->accountingTypeRepo->updateType($requestData, $typeUuid);

        if(!$boolResult){
            abort(404, "Invoice type hasn't updated.");
        }

        return ($boolResult);
    }

    /**
     * @param string $typeUuid
     * @return mixed
     */
    public function deleteInvoiceType(string $typeUuid){
        $boolResult = $this->accountingTypeRepo->deleteType($typeUuid);

        if(!$boolResult){
            abort(404, "Invoice type hasn't deleted.");
        }

        return ($boolResult);
    }
}

<?php

namespace Tests\Unit\Account;

use Faker\Factory;
use Tests\TestCase;
use App\Contracts\Accounting\Invoice as InvoiceContract;
use App\Models\Accounting\AccountingType as AccountingTypeModel;
use App\Models\Accounting\AccountingInvoice as AccountingInvoiceModel;
use App\Models\Accounting\AccountingInvoiceType as AccountingInvoiceTypeModel;
use App\Models\Accounting\AccountingTransactionType as AccountingTransactionTypeModel;

class InvoicesTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private AccountingInvoiceModel $invoice;
    private InvoiceContract $invoiceService;
    private AccountingInvoiceTypeModel $invoiceType;
    private AccountingTypeModel $accountingType;
    private AccountingTransactionTypeModel $accountingTransactionType;

    public function setUp(): void {
        parent::setUp();

        $this->invoice = AccountingInvoiceModel::factory()->create();
        $this->invoiceService = resolve(InvoiceContract::class);
        $this->invoiceType = AccountingInvoiceTypeModel::first();
        $this->accountingType = AccountingTypeModel::factory()->create();
        $this->accountingTransactionType = AccountingTransactionTypeModel::first();
    }

    public function testGetInvoices(){
        $count = AccountingInvoiceModel::count();
        $arrInvoices = $this->invoiceService->findAll([]);

        $this->assertCount($count, $arrInvoices);
    }

    public function testGetUserInvoices(){
        $objInvoices = $this->invoiceService->getUserInvoices($this->invoice->user_uuid, 20);

        foreach ($objInvoices as $objInvoice){
            $this->assertEquals($objInvoice->user_uuid, $this->invoice->user_uuid);
        }
    }

    public function testGetInvoiceByUuid(){
        $objInvoice = $this->invoiceService->getInvoiceByUuid($this->invoice->invoice_uuid);

        $this->assertEquals($objInvoice->invoice_uuid, $this->invoice->invoice_uuid);
    }

    public function testFindInvoiceType(){
        $objInvoiceTypeFound = $this->invoiceService->findInvoiceType($this->invoiceType->type_uuid);
        $this->assertEquals($objInvoiceTypeFound->type_uuid, $this->invoiceType->type_uuid);
    }

    public function testGetInvoiceByInvalidUuid(){
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage("Invoice doesn't exist.");
        $objInvoice = $this->invoiceService->getInvoiceByUuid("INVALID-UUID");
    }

    public function testGetInvoiceTypes(){
        $count = AccountingInvoiceTypeModel::count();
        $objInvoiceTypes = $this->invoiceService->getInvoiceTypes();

        $this->assertCount($count, $objInvoiceTypes);
    }

    public function testCreateInvoiceType(){
        $accountingType = $this->invoiceService->createInvoiceType(
            ["accounting_type_name" => "testName", "accounting_type_memo" => "testMemo"]
        );

        $this->assertEquals($accountingType->accounting_type_name, "testName");
    }

    public function testUpdateInvoiceType(){
        $boolResult = $this->invoiceService->updateInvoiceType(
            [
                "accounting_type_name" => "testNameUpdate",
                "accounting_type_memo" => "testMemoUpdate"
            ],
            $this->accountingType->accounting_type_uuid
        );

        $this->accountingType->refresh();
        $this->assertTrue(boolval($boolResult));
        $this->assertEquals($this->accountingType->accounting_type_name, "testNameUpdate");
    }

    public function testDeleteInvoiceType(){
        $accountingType = $this->invoiceService->createInvoiceType(
            ["accounting_type_name" => "testNameForDelete", "accounting_type_memo" => "testMemoForDelete"]
        );

        $boolResult = $this->invoiceService->deleteInvoiceType($accountingType->accounting_type_uuid);
        $this->assertTrue(boolval($boolResult));
    }
}

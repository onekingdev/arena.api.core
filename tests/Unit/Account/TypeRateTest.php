<?php

namespace Tests\Unit\Account;

use Tests\TestCase;
use App\Contracts\Accounting\TypeRate as TypeRateContract;
use App\Models\Accounting\AccountingType as AccountingTypeModel;
use App\Models\Accounting\AccountingTypeRate as AccountingTypeRateModel;

class TypeRateTest extends TestCase
{

    private $typeRateService;
    private AccountingTypeRateModel $typeRate;

    public function setUp(): void {
        parent::setUp();

        $this->typeRateService = resolve(TypeRateContract::class);
        /** @var AccountingTypeModel $accountingType */
        $accountingType = AccountingTypeModel::factory()->create();
        $this->typeRate = $accountingType->accountingTypeRates()->create(AccountingTypeRateModel::factory()->make([
            "accounting_type_id" => $accountingType->accounting_type_id,
            "accounting_type_uuid" => $accountingType->accounting_type_uuid,
        ])->setHidden([])->toArray());
    }

    public function testGetCharges(){
        $count = AccountingTypeRateModel::count();
        $objTypeRates = $this->typeRateService->getCharges();

        $this->assertCount($count, $objTypeRates);

        foreach($objTypeRates as $objTypeRate){
            $this->assertArrayHasKey("row_uuid", $objTypeRate);
            $this->assertArrayHasKey("accounting_type_uuid", $objTypeRate);
            $this->assertArrayHasKey("accounting_version", $objTypeRate);
            $this->assertArrayHasKey("accounting_rate", $objTypeRate);
            $this->assertArrayHasKey("stamp_created", $objTypeRate);
            $this->assertArrayHasKey("stamp_created_at", $objTypeRate);
            $this->assertArrayHasKey("stamp_created_by", $objTypeRate);
            $this->assertArrayHasKey("stamp_updated", $objTypeRate);
            $this->assertArrayHasKey("stamp_updated_at", $objTypeRate);
            $this->assertArrayHasKey("stamp_updated_by", $objTypeRate);
        }
    }

    public function testsaveCharges(){
        $objTypeRates = $this->typeRateService->saveCharges([11, 05]);

        foreach($objTypeRates as $objTypeRate){
            $this->assertArrayHasKey("accounting_type_uuid", $objTypeRate);
            $this->assertArrayHasKey("accounting_type_name", $objTypeRate);
            $this->assertArrayHasKey("accounting_type_memo", $objTypeRate);
            $this->assertArrayHasKey("stamp_created", $objTypeRate);
            $this->assertArrayHasKey("stamp_created_at", $objTypeRate);
            $this->assertArrayHasKey("stamp_created_by", $objTypeRate);
            $this->assertArrayHasKey("stamp_updated", $objTypeRate);
            $this->assertArrayHasKey("stamp_updated_at", $objTypeRate);
            $this->assertArrayHasKey("stamp_updated_by", $objTypeRate);
        }
    }

    public function testUpdateTypeRate(){
        $boolResult = $this->typeRateService->updateTypeRate(
            [
                "accounting_type_uuid" => "11111111-1111-1111-1111-111111111111",
                "accounting_rate" => 9.99
            ],
            $this->typeRate->row_uuid
        );

        $this->assertTrue(boolval($boolResult));
    }

    public function testDeleteTypeRate(){
        $boolResult = $this->typeRateService->deleteTypeRate($this->typeRate->row_uuid);

        $this->assertTrue(boolval($boolResult));
    }
}

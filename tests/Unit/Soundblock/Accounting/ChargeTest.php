<?php

namespace Tests\Unit\Soundblock\Accounting;

use Tests\TestCase;
use App\Models\Core\App;
use App\Contracts\Soundblock\Accounting\Charge as ChargeContract;
use App\Models\Soundblock\Accounts\Account as SoundblockServiceModel;
use App\Models\Soundblock\Accounts\AccountTransaction as ServiceTransactionModel;

class ChargeTest extends TestCase
{
    private SoundblockServiceModel $serviceModel;
    private ChargeContract $chargeService;

    public function setUp(): void {
        parent::setUp();

        $this->serviceModel = SoundblockServiceModel::first();
        $this->chargeService = resolve(ChargeContract::class);
    }

    public function testChargeService(){
        $objSoundblock = App::where("app_name", "soundblock")->first();
        $objServiceTransaction = $this->chargeService->chargeAccount($this->serviceModel, 'user', $objSoundblock);

        $this->assertInstanceOf(ServiceTransactionModel::class, $objServiceTransaction);

        $this->assertArrayHasKey("row_uuid", $objServiceTransaction);
        $this->assertArrayHasKey("service_uuid", $objServiceTransaction);
        $this->assertArrayHasKey("accounting_type_uuid", $objServiceTransaction);
        $this->assertArrayHasKey("transaction_uuid", $objServiceTransaction);
        $this->assertArrayHasKey("stamp_created", $objServiceTransaction);
        $this->assertArrayHasKey("stamp_updated", $objServiceTransaction);
        $this->assertArrayHasKey("stamp_created_by", $objServiceTransaction);
        $this->assertArrayHasKey("stamp_updated_by", $objServiceTransaction);
        $this->assertArrayHasKey("stamp_updated_at", $objServiceTransaction);
        $this->assertArrayHasKey("stamp_created_at", $objServiceTransaction);
    }
}

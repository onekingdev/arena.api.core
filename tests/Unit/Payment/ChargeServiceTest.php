<?php

namespace Tests\Unit\Payment;

use Tests\TestCase;
use App\Models\Core\App;
use App\Models\Users\User;
use App\Models\Accounting\AccountingType;
use App\Models\Soundblock\Accounts\Account;
use App\Facades\Soundblock\Accounting\Charge;
use App\Models\Soundblock\Accounts\AccountTransaction;
use App\Contracts\Soundblock\Accounting\Charge as ChargeContract;

class ChargeServiceTest extends TestCase {
    /**
     * @var ChargeContract
     */
    private $chargeService;
    /**
     * @var User
     */
    private $user;
    /**
     * @var Account
     */
    private $userService;

    public function setUp(): void {
        parent::setUp();

        $this->chargeService = resolve(ChargeContract::class);
        $this->user = User::factory()->create();
        $this->userService = $this->user->service()->create(Account::factory()->make([
            "user_uuid"         => $this->user->user_uuid
        ])->setAppends([])->toArray());
    }

    public function testChargeUserMethod() {
        $objApp = App::find(8);
        /** @var AccountingType $chargeType */
        $chargeType = AccountingType::find(1);
        $chargeRate = $chargeType->accountingTypeRates()->where("accounting_version", $this->userService->accounting_version)->first();
        $countBefore = $this->userService->transactions()->count();

        $objTransaction = $this->chargeService->chargeAccount($this->userService, strtolower($chargeType->accounting_type_name), $objApp);

        $countAfter = $this->userService->transactions()->count();
        $this->assertInstanceOf(AccountTransaction::class, $objTransaction);

        $this->assertDatabaseHas("soundblock_services_transactions", [
            "service_id"     => $this->userService->service_id,
            "accounting_type_id" => $chargeType->accounting_type_id,
        ]);

        $this->assertDatabaseHas("accounting_transactions", [
            "app_id"             => $objApp->app_id,
            "app_uuid"           => $objApp->app_uuid,
            "app_table"          => $objTransaction->getTable(),
            "app_field"          => $objTransaction->getKeyName(),
            "app_field_id"       => $objTransaction->getKey(),
            "app_field_uuid"     => $objTransaction->row_uuid,
            "transaction_amount" => $chargeRate->accounting_rate,
            "transaction_name"   => ucfirst($objApp->app_name) . " Transaction",
            "transaction_memo"   => ucfirst($objApp->app_name) . " Transaction",
        ]);

        $this->assertGreaterThan($countBefore, $countAfter);
    }

    public function testInvalidChargeTypeArgument() {
        $objApp = App::find(8);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Provided Accounting Type Is Not Supported.");
        $this->expectExceptionCode(400);
        $this->chargeService->chargeAccount($this->userService, "someInvalidTestName", $objApp);
    }

    public function testFacade() {
        $objApp = App::find(8);
        /** @var AccountingType $accountingType */
        $accountingType = AccountingType::find(1);
        $accountingRate = $accountingType->accountingTypeRates()->where("accounting_version", $this->userService->accounting_version)->first();
        $countBefore = $this->userService->transactions()->count();

        $objTransaction = Charge::chargeAccount($this->userService, strtolower($accountingType->accounting_type_name), $objApp);

        $countAfter = $this->userService->transactions()->count();
        $this->assertInstanceOf(AccountTransaction::class, $objTransaction);

        $this->assertDatabaseHas("soundblock_services_transactions", [
            "service_id"     => $this->userService->service_id,
            "accounting_type_id" => $accountingType->accounting_type_id,
        ]);

        $this->assertDatabaseHas("accounting_transactions", [
            "app_id"             => $objApp->app_id,
            "app_uuid"           => $objApp->app_uuid,
            "app_table"          => $objTransaction->getTable(),
            "app_field"          => $objTransaction->getKeyName(),
            "app_field_id"       => $objTransaction->getKey(),
            "app_field_uuid"     => $objTransaction->row_uuid,
            "transaction_amount" => $accountingRate->accounting_rate,
            "transaction_name"   => ucfirst($objApp->app_name) . " Transaction",
            "transaction_memo"   => ucfirst($objApp->app_name) . " Transaction",
        ]);

        $this->assertGreaterThan($countBefore, $countAfter);
    }
}

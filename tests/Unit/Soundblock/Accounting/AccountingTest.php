<?php

namespace Tests\Unit\Soundblock\Accounting;

use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use Laravel\Passport\Passport;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Users\User as UserModel;
use App\Models\Core\Auth\AuthPermission;
use App\Contracts\Payment\Payment as PaymentContract;
use App\Http\Controllers\Account\Payments as PaymentsController;
use App\Models\Soundblock\Accounts\Account as SoundblockServiceModel;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;
use App\Contracts\Soundblock\Accounting\Accounting as AccountingContract;

class AccountingTest extends TestCase
{
    private UserModel $user;
    private PaymentContract $paymentContract;
    private SoundblockServiceModel $serviceModel;
    private AccountingContract $accountingService;
    private PaymentsController $paymentController;

    public function setUp(): void {
        parent::setUp();

        $this->paymentContract = resolve(PaymentContract::class);
        $this->accountingService = resolve(AccountingContract::class);
        $this->paymentController = resolve(PaymentsController::class);

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.office.web";

        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));
        $this->serviceModel = $this->user->service()->save(SoundblockServiceModel::factory()->make(["user_uuid" => $this->user->user_uuid]));
        /** @var App $objApp */
        $objApp = App::where("app_name", "office")->first();

        /** @var AuthGroup $objGroup */
        $objGroup = AuthGroup::where("group_name", "App.Office")->first();
        $objGroup->users()->attach($this->user->user_id, [
            "row_uuid"   => Util::uuid(),
            "user_uuid"  => $this->user->user_uuid,
            "group_uuid" => $objGroup->group_uuid,
            "app_id"     => $objApp->app_id,
            "app_uuid"   => $objApp->app_uuid,
        ]);

        /** @var AuthPermission $objPermission */
        $objPermission = AuthPermission::where("permission_name", "App.Office.Access")->first();
        $objPermission->pusers()->attach($this->user->user_id, [
            "row_uuid"         => Util::uuid(),
            "group_id"         => $objGroup->group_id,
            "group_uuid"       => $objGroup->group_uuid,
            "user_uuid"        => $this->user->user_uuid,
            "permission_uuid"  => $objPermission->permission_uuid,
            "permission_value" => true,
        ]);
    }

    public function testMakeCharge(){
        $this->paymentContract->getOrCreateCustomer($this->user);
        $paymentMethod = $this->paymentContract->addPaymentMethod($this->user, "pm_card_visa");
        $boolResult = $this->accountingService->makeCharge($this->serviceModel, 10.90, $paymentMethod);

        $this->assertEquals($boolResult, true);
    }

    public function testChargeUserImmediately(){
        $this->user->service->update(["flag_status" => "past due accounts"]);
        $this->user->service->refresh();
        $this->user->createOrGetStripeCustomer([
            "name"     => $this->user->full_name,
            "metadata" => [
                "user_uuid" => $this->user->user_uuid,
            ],
        ]);
        $this->user->updateDefaultPaymentMethod("pm_card_visa");

        $boolResult = $this->accountingService->chargeUserImmediately($this->user, $this->user->defaultPaymentMethod());

        $this->assertTrue($boolResult);
    }
}

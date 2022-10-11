<?php

namespace Tests\Unit\Payment;

use App\Models\Accounting\AccountingType;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Users\User;
use Stripe\BalanceTransaction;
use App\Models\Soundblock\Projects\Team;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Soundblock\Accounts\AccountPlan;
use App\Models\Accounting\AccountingTransaction;
use App\Contracts\Soundblock\Accounting\Accounting;
use App\Models\Soundblock\Accounts\AccountTransaction;

class FinanceServiceTest extends TestCase {
    /**
     * @var Accounting
     */
    private $service;
    /**
     * @var User
     */
    private $user;
    /**
     * @var Account
     */
    private $userService;
    /**
     * @var AccountPlan
     */
    private $servicePlan;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    private $serviceTransactions;

    private $accountingSum = 0;
    /**
     * @var Project
     */
    private $project;
    /**
     * @var Team
     */
    private $team;
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $teamUsers;
    private $accountingType;

    public function setUp(): void {
        parent::setUp();

        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));

        $this->service = resolve(Accounting::class);

        $this->user = User::factory()->create();
        $this->user->createAsStripeCustomer();

        $this->userService = $this->user->service()->create(Account::factory()->make([
            "user_uuid" => $this->user->user_uuid,
        ])->setAppends([])->toArray());

        $this->servicePlan = $this->userService->plans()->create(AccountPlan::factory()->make([
            "service_uuid" => $this->user->user_uuid,
        ])->toArray());

        $this->accountingType = AccountingType::factory()->create();

        $this->serviceTransactions = AccountTransaction::factory()->count(5)->dummyLedgerData()->create([
            "service_id"           => $this->userService->service_id,
            "service_uuid"         => $this->userService->service_uuid,
            "accounting_type_id"   => $this->accountingType->accounting_type_id,
            "accounting_type_uuid" => $this->accountingType->accounting_type_uuid,
        ])->makeVisible(["transaction_id", "ledger_id", "service_id", "accounting_type_id"])
                                                       ->each(function ($transaction) {
                                                           $accountingArray = AccountingTransaction::factory()->create([
                                                               "app_field"            => "transaction_id",
                                                               "app_field_id"         => $transaction->row_id,
                                                               "app_field_uuid"       => $transaction->row_uuid,
                                                               "accounting_type_id"   => $this->accountingType->accounting_type_id,
                                                               "accounting_type_uuid" => $this->accountingType->accounting_type_uuid,
                                                           ])->makeVisible(["app_id", "app_field_id"]);
                                                           $this->accountingSum += $accountingArray->transaction_amount;
                                                           /** @var AccountTransaction $transaction */
                                                           $transaction->accountingTransaction()
                                                                       ->associate($accountingArray);
                                                           $transaction->transaction_uuid = $accountingArray->transaction_uuid;
                                                           $transaction->save();
                                                       });

//        $this->project = $this->userService->projects()->create(Project::factory()->make([
//            "service_uuid" => Util::uuid(),
//        ])->setAppends([])->toArray());
//
//        $this->team = $this->project->team()->create(Team::factory()->make([
//            "project_uuid" => $this->project->project_uuid,
//        ])->toArray());

        $this->teamUsers = User::factory()->count(5)->create()->each(function (User $user) {
            $user->services()->attach($this->userService->service_id, [
                "row_uuid"      => Util::uuid(),
                "service_uuid"  => $this->userService->service_uuid,
                "user_uuid"     => $user->user_uuid,
                "flag_accepted" => true,
            ]);
        });
    }

    public function testMakeChargeMethod() {
        $countBeforeCharge = BalanceTransaction::all(["limit" => 999999999])->count();
        $totalNeedPay = ($this->accountingSum + $this->servicePlan->plan_cost + ($this->teamUsers->count() * 0.5)) * 100;

        $objMethod = $this->user->updateDefaultPaymentMethod("pm_card_visa");
        $bnCharged = $this->service->makeCharge($this->userService, $this->servicePlan->plan_cost);
        $this->assertTrue($bnCharged);

        $countAfterCharge = BalanceTransaction::all(["limit" => 999999999])->count();

        /** @var BalanceTransaction $lastCharge */
        $lastCharge = BalanceTransaction::all()->data[0];
        $this->assertEquals($totalNeedPay, $lastCharge->amount);
        $this->assertEquals($countBeforeCharge, $countAfterCharge);
        $objMethod->delete();
    }

    public function testMakeChargeMethodWithSubCharges() {
        $reflection = new \ReflectionClass($this->service);
        $chargeProp = $reflection->getProperty("chargeNotDefault");
        $chargeProp->setAccessible(true);
        $chargeProp->setValue($this->service, true);

        $countBeforeCharge = BalanceTransaction::all(["limit" => 999999999])->count();
        $defaultPm = $this->user->updateDefaultPaymentMethod("pm_card_chargeCustomerFail");
        $pm = $this->user->addPaymentMethod("pm_card_visa");

        $bnCharged = $this->service->makeCharge($this->userService, $this->servicePlan->plan_cost);
        $this->assertTrue($bnCharged);

        $countAfterCharge = BalanceTransaction::all(["limit" => 999999999])->count();

        $this->assertEquals($countBeforeCharge, $countAfterCharge);
        $defaultPm->delete();
        $pm->delete();
    }

    public function testFailedChargeMethodWithSubCharges() {
        $reflection = new \ReflectionClass($this->service);
        $chargeProp = $reflection->getProperty("chargeNotDefault");
        $chargeProp->setAccessible(true);
        $chargeProp->setValue($this->service, false);

        $countBeforeCharge = BalanceTransaction::all(["limit" => 999999999])->count();
        $defaultPm = $this->user->updateDefaultPaymentMethod("pm_card_chargeCustomerFail");
        $pm = $this->user->addPaymentMethod("pm_card_visa");

        $bnCharged = $this->service->makeCharge($this->userService, $this->servicePlan->plan_cost);
        $this->assertFalse($bnCharged);

        $countAfterCharge = BalanceTransaction::all(["limit" => 999999999])->count();

        $this->assertEquals($countBeforeCharge, $countAfterCharge);
        $defaultPm->delete();
        $pm->delete();
    }
}

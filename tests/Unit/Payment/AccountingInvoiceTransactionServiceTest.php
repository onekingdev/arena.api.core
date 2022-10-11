<?php

namespace Tests\Unit\Payment;

use Log;
use Auth;
use Client;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Stripe\Coupon as StripeCoupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Accounting\Invoice as InvoiceService;
use App\Contracts\Accounting\{
    InvoiceTransaction,
};
use App\Contracts\Accounting\{
    Invoice as InvoiceContract,
};
use App\Contracts\Payment\Payment;
use App\Facades\Accounting\Invoice;
use App\Contracts\Soundblock\Accounting\Charge as AccountingChargeContract;
use App\Services\Soundblock\AccountTransaction as ServiceTransactionService;
use App\Models\{
    Core\App,
    Accounting\AccountingType,
    Soundblock\Accounts\Account,
    Soundblock\Accounts\AccountTransaction,
    Users\User,
    Users\Contact\UserContactEmail,
};

class AccountingInvoiceTransactionServiceTest extends TestCase
{

    /**
     * @var InvoiceTransaction
     */
    private $transactionService;
    /**
     * @var InvoiceService
     */
    private $invoiceService;
    /**
     * @var Payment
     */
    private $paymentService;
    /**
     * @var ChargeContract
     */
    private $chargeService;
    /**
     * @var ServiceTransactionService
     */
    private ServiceTransactionService $serviceTransactionService;
    /**
     * @var User
     */
    private $objUser;
    /**
     * @var Account
     */
    private $objService;
    public function setUp(): void
    {
        parent::setUp();
        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
        Client::checkingAs("app.arena.office.web");
        $this->invoiceService = resolve(InvoiceContract::class);
        $this->paymentService = resolve(Payment::class);
        $this->chargeService = resolve(AccountingChargeContract::class);
        $this->serviceTransactionService = resolve(ServiceTransactionService::class);

        $this->objUser = User::factory()->create();
        $this->objUser->emails()->create(UserContactEmail::factory()->verified()->make([
            "user_uuid" => $this->objUser->user_uuid,
            "flag_primary" => true
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());
        $this->objService = $this->objUser->service()->create(
            Account::factory()->make([
                "user_uuid"         => $this->objUser->user_uuid
            ])->setAppends([])->toArray()
        );
        Passport::actingAs($this->objUser);
        // Add a payment method.
        $this->paymentService->getOrCreateCustomer($this->objUser);
        $this->paymentService->addPaymentMethod($this->objUser, "pm_card_visa");
    }
}

<?php

namespace Tests\Unit\Payment;

use Tests\TestCase;
use Stripe\Customer;
use App\Helpers\Util;
use App\Models\{Users\User, Users\Contact\UserContactEmail};
use Laravel\Cashier\PaymentMethod;
use App\Contracts\Payment\Payment;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PaymentServiceTest extends TestCase {
    /**
     * @var Payment
     */
    private $service;

    public function setUp(): void {
        parent::setUp();

        $this->service = resolve(Payment::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateCustomerWithoutEmail() {
        $this->expectException(AccessDeniedHttpException::class);
        $this->expectExceptionMessage("You must to have email address.");
        $user = User::factory()->create();
        $this->service->getOrCreateCustomer($user);
    }

    public function testCreateCustomer() {
        /** @var User $user */
        $user = User::factory()->create();
        $user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

        $objCustomer = $this->service->getOrCreateCustomer($user);

        $this->assertInstanceOf(Customer::class, $objCustomer);
    }

    public function testGetCustomer() {
        /** @var User $user */
        $user = User::factory()->create();
        $objEmail = $user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

        $objStripeCustomer = $user->createAsStripeCustomer();

        $objCustomer = $this->service->getOrCreateCustomer($user);

        $this->assertInstanceOf(Customer::class, $objCustomer);
        $this->assertEquals($objCustomer->id, $objStripeCustomer->id);
    }

    public function testAddPaymentMethod() {
        /** @var User $user */
        $user = User::factory()->create();
        $user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

        $user->createAsStripeCustomer();

        $objPaymentMethod = $this->service->addPaymentMethod($user, "pm_card_visa");
        $this->assertInstanceOf(PaymentMethod::class, $objPaymentMethod);
        $this->assertCount(1, $user->paymentMethods());
    }

    public function testGettingPaymentMethod() {
        /** @var User $user */
        $user = User::factory()->create();
        $user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

        $user->createAsStripeCustomer();
        $user->addPaymentMethod("pm_card_visa");

        $arrMethods = $this->service->getUserPaymentMethods($user);

        $this->assertIsArray($arrMethods);
        $this->assertCount(1, $arrMethods);
    }

    public function testDeletingPaymentMethod() {
        /** @var User $user */
        $user = User::factory()->create();
        $user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

        $user->createAsStripeCustomer();
        $paymentMethod = $user->addPaymentMethod("pm_card_visa");
        $this->service->deletePaymentMethod($user, $paymentMethod->id);

        $this->assertCount(0, $user->paymentMethods());
    }

    public function testDeleteAllMethods() {
        /** @var User $user */
        $user = User::factory()->create();
        $user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

        $user->createAsStripeCustomer();
        $user->addPaymentMethod("pm_card_visa");
        $user->addPaymentMethod("pm_card_visa");
        $this->service->deleteUserPaymentMethods($user);

        $this->assertCount(0, $user->paymentMethods());
    }

    public function testUpdateDefaultMethod() {
        /** @var User $user */
        $user = User::factory()->create();
        $user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

        $user->createAsStripeCustomer();
        $paymentMethod = $user->addPaymentMethod("pm_card_visa");
        $this->assertNull($user->defaultPaymentMethod());

        $this->service->updateDefaultMethod($user, $paymentMethod->id);

        $objDefaultMethod = $user->defaultPaymentMethod();
        $this->assertInstanceOf(PaymentMethod::class, $user->defaultPaymentMethod());
        $this->assertEquals($paymentMethod->id, $objDefaultMethod->id);
    }
}

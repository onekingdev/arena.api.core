<?php

namespace App\Contracts\Payment;

use Stripe\Customer;
use App\Models\Users\User;
use Laravel\Cashier\PaymentMethod;

interface Payment {
    public function getOrCreateCustomer(User $user): Customer;

    public function getUserPaymentMethods(User $user): array;

    public function addPaymentMethod(User $user, string $paymentMethodId): PaymentMethod;

    public function deletePaymentMethod(User $user, string $paymentMethodId): void;

    public function deleteUserPaymentMethods(User $user): void;

    public function updateDefaultMethod(User $user, string $methodId): void;
}

<?php


namespace App\Contracts\Core\Webhooks;


interface SimpleNotification {
    public function confirmSubscription(array $confirmationData): bool;
}
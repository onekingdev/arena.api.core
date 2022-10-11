<?php

namespace App\Contracts\Core;

interface ShoppingCart {
    public function addItemToCart(array $requestData, string $clientIp, $objUser = null);
    public function getUserItems(string $clientIp, $objUser = null);
    public function deleteUserItem(string $itemUuid, string $clientIp, $objUser = null);
    public function payment($requestData, string $clientIp, $objUser = null);
    public function updateCartByPaymentId(string $paymentMethod, string $status);
    public function getCartByPaymentMethod(string $paymentMethod);
}
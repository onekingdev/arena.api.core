<?php

namespace App\Services\Core;

use Util;
use Laravel\Cashier\Billable;
use App\Models\Users\User as UserModel;
use App\Traits\Core\ShoppingCart as ShoppingCartTrait;
use App\Repositories\Core\CartItem as CartItemRepository;
use App\Repositories\Apparel\Product as ProductRepository;
use App\Contracts\Core\ShoppingCart as ShoppingCartContract;
use App\Repositories\Core\ShoppingCart as ShoppingCartRepository;

class ShoppingCart implements ShoppingCartContract{
    use Billable;
    use ShoppingCartTrait;

    /**
     * @var ShoppingCartRepository
     */
    private ShoppingCartRepository $cartRepo;
    /**
     * @var CartItemRepository
     */
    private CartItemRepository $cartItemsRepo;
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepo;

    /**
     * ShoppingCart constructor.
     * @param CartItemRepository $cartItem
     * @param ShoppingCartRepository $ShoppingCart
     * @param ProductRepository $product
     */
    public function __construct(CartItemRepository $cartItem, ShoppingCartRepository $ShoppingCart,
                                ProductRepository $product) {
        $this->cartRepo      = $ShoppingCart;
        $this->cartItemsRepo = $cartItem;
        $this->productRepo   = $product;
    }

    /**
     * @param array $requestData
     * @param string $clientIp
     * @param null $objUser
     * @return mixed
     * @throws \Exception
     */
    public function addItemToCart(array $requestData, string $clientIp, $objUser = null){
        $insertData = [];
        $objProduct = $this->productRepo->find($requestData["model_uuid"]);

        $objCart = $this->cartRepo->getUserCart($clientIp, $objUser);

        if (is_null($objCart)){
            $objCart = $this->cartRepo->createCart($clientIp, $objUser);
        }

        $insertData["row_uuid"]   = Util::uuid();
        $insertData["model_uuid"] = $objProduct->product_uuid;
        $insertData["cart_id"]    = $objCart->row_id;
        $insertData["cart_uuid"]  = $objCart->row_uuid;
        $insertData["quantity"]   = $requestData["quantity"];

        return ($objProduct->item()->create($insertData));
    }

    /**
     * @param string $clientIp
     * @param null $objUser
     * @return |null
     */
    public function getUserItems(string $clientIp, $objUser = null){
        $objCart = $this->cartRepo->getUserCart($clientIp, $objUser);

        if (is_null($objCart)){
            return (null);
        }

        return ($objCart->items);
    }

    /**
     * @param string $itemUuid
     * @param string $clientIp
     * @param null $objUser
     * @return mixed
     */
    public function deleteUserItem(string $itemUuid, string $clientIp, $objUser = null){
        $objCart = $this->cartRepo->getUserCart($clientIp, $objUser);

        if (is_null($objCart)){
            abort(404, "User hasn't cart.");
        }

        return ($objCart->items()->where("row_uuid", $itemUuid)->delete());
    }

    /**
     * @param $requestData
     * @param string $clientIp
     * @param null $objUser
     * @return mixed
     * @throws \Laravel\Cashier\Exceptions\PaymentActionRequired
     * @throws \Laravel\Cashier\Exceptions\PaymentFailure
     */
    public function payment($requestData, string $clientIp, $objUser = null){
        $objCart = $this->cartRepo->getUserCart($clientIp, $objUser);

        if (is_null($objCart)){
            abort(404, "User hasn't cart.");
        }

        $amount = $this->getCartAmount($objCart);
        $stripeCharge = (new UserModel)->charge($amount, $requestData['payment_method']);

        $arrPaymentDetails["payment_id"] = $stripeCharge->id;
        $arrPaymentDetails["payment_method"] = $stripeCharge->payment_method;
        $arrPaymentDetails["status"] = $stripeCharge->status;

        return ($objCart->update($arrPaymentDetails));
    }

    /**
     * @param string $paymentMethod
     * @param string $status
     */
    public function updateCartByPaymentId(string $paymentMethod, string $status){
        $this->cartRepo->updateCart($paymentMethod, $status);
    }

    /**
     * @param string $paymentMethod
     * @return mixed
     */
    public function getCartByPaymentMethod(string $paymentMethod){
        $objCart = $this->cartRepo->getCartByPaymentMethod($paymentMethod);

        if (is_null($objCart)){
            abort(404, "Shopping cart not found.");
        }

        return ($objCart);
    }
}

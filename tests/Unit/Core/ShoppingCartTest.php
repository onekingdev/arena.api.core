<?php

namespace Tests\Unit\Core;

use Faker\Factory;
use Tests\TestCase;
use App\Models\Core\CartItem as CartItemModel;
use App\Models\Apparel\Product as ProductModel;
use App\Models\Core\ShoppingCart as ShoppingCartModel;
use App\Contracts\Core\ShoppingCart as ShoppingCartContract;

class ShoppingCartTest extends TestCase
{
    private ShoppingCartContract $shoppingCartService;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private ShoppingCartModel $cart;
    private ProductModel $product;

    public function setUp(): void {
        parent::setUp();

        ShoppingCartModel::where("stamp_deleted_at", null)->update(["status" => "succeeded"]);
        $this->shoppingCartService = resolve(ShoppingCartContract::class);
        $this->cart = ShoppingCartModel::factory()->create();
        $this->product = ProductModel::first();
    }

    public function testCreateItem(){
        $objItem = $this->shoppingCartService->addItemToCart(
            [
                "model_uuid" => $this->product->product_uuid,
                "quantity"   => 2
            ],
            $this->cart->user_ip,
            null
        );

        $this->assertEquals($objItem->cart_id, $this->cart->row_id);
        $this->assertEquals($objItem->model_uuid, $this->product->product_uuid);
    }

    public function testGetItems(){
        $count = $this->cart->items()->count();
        $arrItems = $this->shoppingCartService->getUserItems($this->cart->user_ip, null);

        $this->assertCount($count, $arrItems);
    }

    public function testDeleteItem(){
        $objItem = $this->shoppingCartService->addItemToCart(
            [
                "model_uuid" => $this->product->product_uuid,
                "quantity"   => 2
            ],
            $this->cart->user_ip,
            null
        );

        $boolResult = $this->shoppingCartService->deleteUserItem($objItem->row_uuid, $this->cart->user_ip);

        $this->assertEquals($boolResult, true);
    }

    public function testPayment(){
        $objItem = $this->shoppingCartService->addItemToCart(
            [
                "model_uuid" => $this->product->product_uuid,
                "quantity"   => 2
            ],
            $this->cart->user_ip,
            null
        );
        $boolResult = $this->shoppingCartService->payment(["payment_method" => "pm_card_visa"], $this->cart->user_ip);

        $this->assertEquals($boolResult, true);
    }

    public function testRefundPayment(){
        $this->shoppingCartService->updateCartByPaymentId($this->cart->payment_method, "charge.refunded");
        $updatedCart = $this->cart->refresh();
        $this->assertEquals($updatedCart->status, ShoppingCartModel::$statuses["charge.refunded"]);
    }

    public function testGetCartByPaymentMethod(){
        $objCart = $this->shoppingCartService->getCartByPaymentMethod($this->cart->payment_method);
        $this->assertEquals($objCart->payment_method, $this->cart->payment_method);
    }
}

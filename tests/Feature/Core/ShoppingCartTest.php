<?php

namespace Tests\Feature\Core;

use Tests\TestCase;
use App\Models\Core\CartItem as CartItemModel;
use App\Models\Apparel\Product as ProductModel;
use App\Models\Core\ShoppingCart as ShoppingCartModel;

class ShoppingCartTest extends TestCase
{
    private CartItemModel $item;
    private ProductModel $product;
    private ShoppingCartModel $cart;

    public function setUp(): void
    {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.office.web";

        $this->product = ProductModel::first();
        $this->item    = CartItemModel::first();
        $this->cart    = ShoppingCartModel::first();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateItem()
    {
        $response = $this->post("/merch/apparel/cart/item", ["model_uuid" => $this->product->product_uuid, "quantity" => 2]);

        $response->assertStatus(200);
    }

    public function testGetItems(){
        $response = $this->get("/merch/apparel/cart/items");
        $response->assertStatus(200);

        $response->assertJsonStructure([
            "data" => [
                [
                    "row_uuid",
                    "cart_uuid",
                    "model_uuid",
                    "model_class",
                    "quantity",
                    "stamp_created",
                    "stamp_created_by",
                    "stamp_updated",
                    "stamp_updated_by",
                ]
            ],
            "status" => [
                "app",
                "code",
                "message"
            ]
        ]);
    }

    public function testDeleteItem(){
        $response = $this->post("/merch/apparel/cart/item", ["model_uuid" => $this->product->product_uuid, "quantity" => 2]);
        $objItem = json_decode($response->getContent(), true);
        $response = $this->delete("/merch/apparel/cart/item/" . $objItem["data"]["row_uuid"] . "");
        $response->assertStatus(200);
    }

    public function testUpdateCart(){
        $responseItem = $this->post("/merch/apparel/cart/item", ["model_uuid" => $this->product->product_uuid, "quantity" => 2]);
        $responseItem->assertStatus(200);

        $responseCart = $this->post("/merch/apparel/cart", ["payment_method" => "pm_card_visa"]);
        $responseCart->assertStatus(200);
    }

    public function testGetCartByPaymentMethod(){
        $response = $this->get("/merch/apparel/cart/method/" . $this->cart->payment_method);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            "data" => [
                "row_uuid",
                "user_uuid",
                "payment_id",
                "payment_method",
                "status",
                "stamp_created",
                "stamp_created_by",
                "stamp_updated",
                "stamp_updated_by"
            ],
            "status" => [
                "app",
                "code",
                "message"
            ]
        ]);
    }
}

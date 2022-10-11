<?php

namespace App\Http\Controllers\Merch\Apparel;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Core\ShoppingCart as ShoppingCartContract;
use App\Http\Requests\Core\UpdateShoppingCart as UpdateShoppingCartRequest;
use App\Http\Requests\Core\AddItemToShoppingCart as AddItemToShoppingCartRequest;

/**
 * @group Merch Apparel
 *
 */
class ShoppingCart extends Controller
{
    private ShoppingCartContract $cart;

    public function __construct(){
        $this->objUser = Auth::user();
        $this->cart    = resolve(ShoppingCartContract::class);
    }

    /**
     * @param AddItemToShoppingCartRequest $request
     * @return mixed
     */
    public function addItem(AddItemToShoppingCartRequest $request){
        $requestData = $request->only([
            "model_uuid",
            "quantity"
        ]);

        $objItem = $this->cart->addItemToCart($requestData, $request->ip(), $this->objUser);

        return ($this->apiReply($objItem, "Item added successfully.", 200));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItems(Request $request){
        $objItems = $this->cart->getUserItems($request->ip(), $this->objUser);

        if (is_null($objItems)){
            return ($this->apiReply(null, "User hasn't items.", 200));
        }

        return ($this->apiReply($objItems, "Success.", 200));
    }

    /**
     * @param Request $request
     * @param string $itemUuid
     * @return mixed
     */
    public function deleteItem(Request $request, string $itemUuid){
        $boolResult = $this->cart->deleteUserItem($itemUuid, $request->ip(), $this->objUser);

        if ($boolResult){
            return ($this->apiReply(null, "Item deleted successfully.", 200));
        }

        return ($this->apiReply(null, "Item hasn't deleted.", 400));
    }

    /**
     * @param UpdateShoppingCartRequest $request
     * @return mixed
     */
    public function payment(UpdateShoppingCartRequest $request){
        $boolResult = $this->cart->payment($request->only(["payment_method"]), $request->ip(), $this->objUser);

        if ($boolResult){
            return ($this->apiReply(null, "Cart updated successfully.", 200));
        }

        return ($this->apiReply(null, "Cart hasn't updated.", 400));
    }

    /**
     * @param Request $request
     */
    public function webhook(Request $request){
        $this->cart->updateCartByPaymentId($request["data"]["object"]["payment_method"], $request->type);
    }

    /**
     * @param string $paymentMethod
     * @return mixed
     */
    public function getCartByPaymentMethod(string $paymentMethod){
        $objCart = $this->cart->getCartByPaymentMethod($paymentMethod);

        return ($this->apiReply($objCart, "Shopping cart get succeeded."));
    }
}

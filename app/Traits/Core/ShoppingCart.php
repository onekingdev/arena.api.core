<?php

namespace App\Traits\Core;

trait ShoppingCart {
    public function getCartAmount($objShoppingCart){
        $objItems = $objShoppingCart->items;
        $amount = 0;

        foreach ($objItems as $objItem){
            $amount += $objItem->item->price->product_price * $objItem->quantity;
        }

        return (str_replace(".", "", number_format($amount, 2)));
    }
}

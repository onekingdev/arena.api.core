<?php

use \Illuminate\Routing\Router;

/** @var Router $objRouter */
$objRouter = resolve("router");

$objRouter->group(["prefix" => "merch", "namespace" => "Merch\FaceCovering"], function (Router $objRouter) {
    $objRouter->post("/facecovering/order", "FaceCovering@handleOrder");
});
$objRouter->group(["prefix" => "merch", "namespace" => "Merch\Tourmask"], function (Router $objRouter) {
    $objRouter->post("/tourmask/order", "Tourmask@handleOrder");
});
$objRouter->group(["prefix" => "merch", "namespace" => "Merch\Apparel"], function (Router $objRouter) {
    $objRouter->group(["prefix" => "apparel", "middleware" => ["check.header"]], function(Router $objRouter){
        /* Categories */
        $objRouter->get('categories', 'Categories@get');
        $objRouter->group(["prefix" => "category"], function (Router $objRouter) {
            $objRouter->get('{categoryUuid}', 'Categories@getProducts');
            $objRouter->get('{categoryUuid}/attributes', 'Categories@getAttributes');
        });
        /* Bootstrap */
        $objRouter->get("bootstrap",  "Categories@bootstrap");
        /* Files */
        $objRouter->get("file/{file}", "Files@getFileUrl");
        /* Products */
        $objRouter->get('products/{productUuid}', 'Products@get');

        $objRouter->group(["prefix" => "cart"], function (Router $objRouter) {
            $objRouter->post("/item", "ShoppingCart@addItem");
            $objRouter->delete("/item/{item}", "ShoppingCart@deleteItem");
            $objRouter->get("/items", "ShoppingCart@getItems");
            $objRouter->post("/", "ShoppingCart@payment");
            $objRouter->get("/method/{method}", "ShoppingCart@getCartByPaymentMethod");
        });
    });
});

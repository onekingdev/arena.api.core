<?php

use \Illuminate\Routing\Router;

/** @var Router $objRouter */
$objRouter = resolve("router");

$objRouter->group(["namespace" => "Core", "middleware" => ["check.header"]], function (Router $objRouter) {
    $objRouter->group(["prefix" => "status"], function (Router $objRouter) {
        $objRouter->get("ping", "Server@ping");
        $objRouter->get("data", "Server@get");
        $objRouter->get("version", "Server@version");
    });
});


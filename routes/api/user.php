<?php

use \Illuminate\Routing\Router;

/** @var Router $objRouter */
$objRouter = resolve("router");

$objRouter->get("/ping", function () {
    return response()->json("pong");
});

$objRouter->group(["middleware" => ["check.header", "auth:api"]], function (Router $objRouter) {
    $objRouter->group(["namespace" => "Core"], function (Router $objRouter) {
        $objRouter->get("users", "User@indexForOffice");
        $objRouter->get("users/avatars", "User@getUsersAvatars");

        $objRouter->group(["prefix" => "user"], function (Router $objRouter) {
            $objRouter->post("/avatar", "User@createAvatar");
            $objRouter->get("/avatar/{user_uuid}", "User@getUserAvatarByUuid");
            $objRouter->post("account", "User@createAccount");
        });
    });

    $objRouter->group(["prefix" => "user"], function (Router $objRouter) {
        $objRouter->group(["namespace" => "Account"], function (Router $objRouter) {
            $objRouter->get("/", "Profile@index");
            $objRouter->get("profile", "Profile@show");
        });
        $objRouter->group(["prefix" => "profile", "namespace" => "Account"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "address"], function (Router $objRouter) {
                $objRouter->get("/", "Profile@getPostals");
                $objRouter->post("/", "Profile@storePostal");
                $objRouter->patch("/", "Profile@updatePostal");
                $objRouter->delete("/", "Profile@deletePostal");
            });

            $objRouter->group(["prefix" => "email"], function (Router $objRouter) {
                $objRouter->get("/", "Profile@getEmails");
                $objRouter->post("/", "Profile@storeEmail");
                $objRouter->patch("/", "Profile@updateEmail");
                $objRouter->delete("/", "Profile@deleteEmail");
            });

            $objRouter->group(["prefix" => "phone"], function (Router $objRouter) {
                $objRouter->get("/", "Profile@getPhones");
                $objRouter->post("/", "Profile@storePhone");
                $objRouter->patch("/", "Profile@updatePhone");
                $objRouter->delete("/", "Profile@deletePhone");
            });

            $objRouter->group(["prefix" => "bank"], function (Router $objRouter) {
                $objRouter->get("/", "Profile@getBankings");
                $objRouter->post("/", "Profile@storeBanking");
                $objRouter->patch("/", "Profile@updateBanking");
                $objRouter->delete("/", "Profile@deleteBankAccount");
            });

            $objRouter->group(["prefix" => "paypal"], function (Router $objRouter) {
                $objRouter->get("/", "Profile@getPaypals");
                $objRouter->post("/", "Profile@storePaypal");
                $objRouter->patch("/", "Profile@updatePaypal");
                $objRouter->delete("/", "Profile@deletePaypal");
            });

            $objRouter->patch("payment/primary", "Profile@setPrimary");

            $objRouter->patch("name", "Profile@updateName");
        });

        $objRouter->group(["namespace" => "Account"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "notes"], function (Router $objRouter) {
                $objRouter->get("/", "UserNote@index");
                $objRouter->post("/", "UserNote@store");
                $objRouter->delete("/", "UserNote@delete");
            });
        });

        $objRouter->group(["namespace" => "Core"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "notification"], function (Router $objRouter) {
                // Test...
                $objRouter->get("send", "Notification@send");
                $objRouter->patch("{notification}/archive", "Notification@archives");
                $objRouter->patch("{notification}/read", "Notification@read");
                $objRouter->patch("{notification}/unread", "Notification@unread");
                $objRouter->get("setting", "Notification@showSetting");
                $objRouter->patch("setting", "Notification@updateSetting");
            });

            $objRouter->group(["prefix" => "notifications"], function (Router $objRouter) {
                $objRouter->get("/", "Notification@index");
                $objRouter->delete("/", "Notification@delete");

                $objRouter->patch("archive", "Notification@archive");
                $objRouter->get("notifications", "Notification@send");
                $objRouter->get("mail", "Notification@sendMail");
            });
        });
    });
});

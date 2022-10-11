<?php

use \Illuminate\Routing\Router;

/** @var Router $objRouter */
$objRouter = resolve("router");

$objRouter->group(["middleware" => ["check.header", "auth:api"]], function (Router $objRouter) {
    $objRouter->group(["prefix" => "core", "namespace" => "Core"], function (Router $objRouter) {
        $objRouter->get("update/platforms", "Api@addPlatforms");
        $objRouter->group(["prefix" => "server/cache"], function (Router $objRouter) {
            $objRouter->get("flush", "Server@flushCache");
        });
        $objRouter->group(["prefix" => "pages"], function (Router $objRouter) {
            $objRouter->get("/", "AppsPages@getPages");
        });

        $objRouter->group(["prefix" => "page"], function (Router $objRouter) {
            /* Page */
            $objRouter->get("/", "AppsPages@getPageByUrl");
            $objRouter->get("/{page_uuid}", "AppsPages@getPageByUuid");
            $objRouter->post("/", "AppsPages@addNewPage");
            $objRouter->delete("/{page_uuid}", "AppsPages@deletePageByUuid");
        });

        $objRouter->get("/autocomplete/users", "User@autocomplete");
        $objRouter->get("/apps", "App@index");


        $objRouter->group(["prefix" => "services", "namespace" => "Services\Support"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "support"], function (Router $objRouter) {
                $objRouter->get("tickets", "Ticket@index");

                $objRouter->group(["prefix" => "ticket"], function (Router $objRouter) {
                    /* Ticket */
                    $objRouter->get("/{ticket}", "Ticket@show");
                    $objRouter->post("/", "Ticket@store");
                    $objRouter->patch("/", "Ticket@update");
                    /* Messages */
                    $objRouter->post("message", "SupportTicketMessage@storeMessage");
                    $objRouter->get("{ticket}/messages", "SupportTicketMessage@index");
                    /* Members */
                    $objRouter->post("{ticket}/member", "Ticket@attachMember");
                    $objRouter->post("{ticket}/members", "Ticket@attachMembers");
                    $objRouter->delete("{ticket}/member", "Ticket@detachMember");
                    $objRouter->delete("{ticket}/members", "Ticket@detachMembers");
                });
            });
        });

        $objRouter->group(["prefix" => "job"], function (Router $objRouter) {
            $objRouter->get("{job}/status", "QueueJob@show");
            $objRouter->patch("/", "QueueJob@update");
        });

        $objRouter->group(["prefix" => "jobs"], function (Router $objRouter) {
            $objRouter->get("status", "QueueJob@status");
        });

        $objRouter->group(["prefix" => "accounting", "namespace" => "Accounting"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "invoice"], function (Router $objRouter) {
                $objRouter->get("/all/invoices", "Invoice@index");
                $objRouter->get("/user/invoices", "Invoice@getUserInvoices");
                $objRouter->get("/{invoice}", "Invoice@getInvoiceByUuid");
                $objRouter->get("/{invoice}/type", "Invoice@getInvoiceType");
                $objRouter->get("/all/types", "Invoice@getInvoiceTypes");
                $objRouter->post("/store", "Invoice@store");

                $objRouter->group(["prefix" => "type"], function (Router $objRouter) {
                    $objRouter->post("/", "Invoice@createInvoiceType");
                    $objRouter->patch("/{type}", "Invoice@updateType");
                    $objRouter->delete("/{type}", "Invoice@deleteType");
                });
            });
        });

        $objRouter->group(["namespace" => "Account"], function (Router $objRouter) {
            $objRouter->post("email/{email}/verify", "Email@sendVerifyEmailMessage");
        });
    });
});

$objRouter->group(["namespace" => "Core", "middleware" => ["check.header"]], function (Router $objRouter) {
    $objRouter->group(["prefix" => "core"], function (Router $objRouter) {
        $objRouter->group(["prefix" => "correspondence"], function (Router $objRouter) {
            $objRouter->post("/", "Correspondence@createCorrespondence");
        });

        $objRouter->group(["prefix" => "social", "namespace" => "Social"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "instagram"], function (Router $objRouter) {
                $objRouter->get("/", "Instagram@getMedia");
            });
        });

        $objRouter->group(["prefix" => "mailing"], function (Router $objRouter) {
            $objRouter->post("/email", "Mailing@addEmail");
        });
    });
});

/* Common Routes */
$objRouter->group(["namespace" => "Core"], function (Router $objRouter) {
    $objRouter->group(["prefix" => "core", "namespace" => "Account"], function (Router $objRouter) {
        $objRouter->patch("email/{hash}", "Email@verifyEmail");
    });
    $objRouter->group(["prefix" => "mailing"], function (Router $objRouter) {
        $objRouter->delete("/email/{email}", "Mailing@deleteEmailByUuid");
    });
    $objRouter->group(["prefix" => "vendors"], function (Router $objRouter) {
        $objRouter->post("/slack/github", "Slack@githubEvent");
        $objRouter->post("/slack/github/actions", "Slack@githubActionsEvent");
    });

    $objRouter->group(["namespace" => "Webhooks", "prefix" => "/webhook"], function (Router $objRouter) {
        $objRouter->post("/sns", "SimpleNotifications@notification");
    });
});

/* Common Routes */
$objRouter->group(["namespace" => "Merch\Apparel"], function (Router $objRouter) {
    $objRouter->group(["prefix" => "core/cart"], function (Router $objRouter) {
        $objRouter->post("stripe/webhook", "ShoppingCart@webhook");
    });
});

/* Auth Routes */
$objRouter->group(["middleware" => ["check.header"]], function (Router $objRouter) {
    $objRouter->group(["prefix" => "core/auth", "namespace" => "Core\Auth"], function (Router $objRouter) {
        $objRouter->post("signin", ["as" => "signin", "uses" => "AuthController@signIn"]);
        $objRouter->post("signup", "AuthController@signUp");
        $objRouter->patch("refresh", "AuthController@userRefresh");

        $objRouter->post("forgot-password", "AuthController@sendPasswordResetMail");
        $objRouter->patch("password-reset/{resetToken}", "AuthController@passwordReset");

        $objRouter->group(["middleware" => "auth:api"], function (Router $objRouter) {
            $objRouter->get("/", "AuthController@isAuthorized");

            $objRouter->delete("signout", "AuthController@signOut");
            $objRouter->post("password", "AuthController@checkPassword");
            $objRouter->patch("password", "AuthController@changePassword");
            $objRouter->get("index", "AuthController@userData");

            $objRouter->group(["prefix" => "2fa"], function (Router $objRouter) {
                $objRouter->group(["prefix" => "secret"], function (Router $objRouter) {
                    $objRouter->get("/", "TwoFactorAuth@getSecret");
                    $objRouter->post("/", "TwoFactorAuth@generateSecret");
                    $objRouter->delete("/", "TwoFactorAuth@removeSecrets");
                });

                $objRouter->post("/verify", "TwoFactorAuth@verifyTwoFactorConnected");
            });
        });

        /* Access Routes */
        $objRouter->group(["prefix" => "access", "middleware" => ["auth:api"]], function (Router $objRouter) {
            $objRouter->group(["prefix" => "group"], function (Router $objRouter) {
                /* Group CRUD */
                $objRouter->post("/", "AuthGroup@store");
                $objRouter->delete("/", "AuthGroup@deleteGroup");
                $objRouter->get("/", "AuthGroup@show");
                /* Group User */
                $objRouter->post("users", "AuthGroup@addUsers");
                $objRouter->delete("users", "AuthGroup@deleteUsersInGroup");
            });

            //Listing all groups
            $objRouter->get("groups", "AuthGroup@index");
            //Listing all Permissions
            $objRouter->get("permissions", "AuthPermission@index");

            $objRouter->group(["prefix" => "permission"], function (Router $objRouter) {
                /* Permission Info */
                $objRouter->get("/", "AuthPermission@show");
                $objRouter->post("/", "AuthPermission@store");
                $objRouter->patch("/{permission}", "AuthPermission@updatePermission");
                /* Permission Group And Users */
                $objRouter->get("{permission}/users", "AuthPermission@getPermissionUsers");
                $objRouter->post("user", "AuthPermission@addPermissionsToUser");
                $objRouter->patch("{permission}/user", "AuthPermission@updateUserPermission");
                $objRouter->delete("{permission}/user", "AuthPermission@deleteUserPermission");

                $objRouter->get("{permission}/groups", "AuthPermission@getPermissionGroups");
                $objRouter->post("group", "AuthPermission@addPermissionsToGroup");
                $objRouter->patch("{permission}/group", "AuthPermission@updatePermissionInGroup");
                $objRouter->delete("{permission}/group", "AuthPermission@deletePermissionInGroup");
            });

            //Listing all permissions in a group.
            $objRouter->get("permissions-in-group", "AuthPermission@getPermissionsInGroup");
            //Remove permissions in a group.
//            $objRouter->delete("permissions-group", "AuthPermission@deletePermissionsInGroup");
            //Remove permissions from a user
//            $objRouter->delete("permissions-user", "AuthPermission@deletePermissionsInUser");
            //Get Users Groups
            $objRouter->get("/user/{user}/groups", "AuthGroup@getUserGroups");
        });
    });
});

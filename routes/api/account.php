<?php

use \Illuminate\Routing\Router;

/** @var Router $objRouter */
$objRouter = resolve("router");

$objRouter->group(["namespace" => "Account", "middleware" => ["check.header"]], function (Router $objRouter) {
    $objRouter->group(["prefix" => "account", "middleware" => "auth:api"], function (Router $objRouter) {
        $objRouter->group(["prefix" => "soundblock"], function (Router $objRouter) {
            /* Soundblock Projects */
            $objRouter->get("/projects", "Soundblock@getProjects");

            $objRouter->group(["prefix" => "project"], function (Router $objRouter) {
                $objRouter->get("/{project_uuid}", "Soundblock@getProject");
                $objRouter->get("/{project_uuid}/deployments", "Soundblock@getProjectDeployments");
                $objRouter->get("/{project_uuid}/account", "Soundblock@getProjectAccount");
                $objRouter->get("/{project_uuid}/members", "Soundblock@getProjectMembers");
            });

            /* Soundblock Accounts */
            $objRouter->get("/accounts", "Soundblock@getAccounts");

            $objRouter->group(["prefix" => "account"], function (Router $objRouter) {
                $objRouter->get("/{account_uuid}", "Soundblock@getAccount");
                $objRouter->get("/{account_uuid}/transaction", "Soundblock@getAccountTransaction");
                $objRouter->get("/{account_uuid}/plan", "Soundblock@getAccountPlan");
                $objRouter->get("/{account_uuid}/user", "Soundblock@getAccountUser");
            });
        });

        /* Soundblock Invoices */
        $objRouter->get("/invoices", "Invoice@getUserInvoices");

        $objRouter->group(["prefix" => "invoice"], function (Router $objRouter) {
            $objRouter->get("/{invoice_uuid}", "Invoice@getInvoiceByUuid");
            $objRouter->get("/{invoice_uuid}/type", "Invoice@getInvoiceType");
        });

        $objRouter->group(["prefix" => "payments"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "method"], function (Router $objRouter) {
                $objRouter->post("/", "Payments@addPaymentMethod");
                $objRouter->get("/", "Payments@getPaymentMethods");
                $objRouter->delete("/{methodId?}", "Payments@deletePaymentMethod");
                $objRouter->put("/default/{methodId}", "Payments@updateDefaultPayment");
            });
        });
    });
});

$objRouter->group(["namespace" => "Soundblock", "middleware" => ["check.header"]], function (Router $objRouter) {
    $objRouter->group(["prefix" => "account", "middleware" => "auth:api"], function (Router $objRouter) {
        $objRouter->delete("/user/account", "AccountPlan@cancel");
    });
});

$objRouter->group(["middleware" => ["check.header"]], function (Router $objRouter) {
    $objRouter->group(["prefix" => "account", "middleware" => "auth:api"], function (Router $objRouter) {
        $objRouter->group(["prefix" => "user", "namespace" => "Core"], function (Router $objRouter) {
            $objRouter->patch("{user}/security", "User@security");
            $objRouter->patch("{user}", "User@update");
        });
    });
});

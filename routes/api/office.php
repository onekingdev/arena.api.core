<?php

use \Illuminate\Routing\Router;

/** @var Router $objRouter */
$objRouter = resolve("router");


$objRouter->group(["middleware" => ["check.header"]], function (Router $objRouter) {

    $objRouter->group(["prefix" => "test", "middleware" => "auth:api"], function (Router $objRouter) {

        $objRouter->group(["namespace" => "Core"], function (Router $objRouter) {
            $objRouter->get("notifications", "Notification@send");
        });

    });

    $objRouter->group(["namespace" => "Office", "prefix" => "office/support", "middleware" => "auth:api"], function (Router $objRouter) {
        $objRouter->get("tickets", "SupportTicket@index");
        $objRouter->get("ticket/{ticket}", "SupportTicket@show");
        $objRouter->post("ticket", "SupportTicket@store");
        $objRouter->patch("ticket/{ticket}/edit", "SupportTicket@editTicket");

        $objRouter->group(["prefix" => "ticket"], function (Router $objRouter) {
            $objRouter->get("{ticket}/messages", "SupportTicketMessage@index");
            $objRouter->post("message", "SupportTicketMessage@storeMessage");

            $objRouter->post("{ticket}/member", "SupportTicket@attachMember");
            $objRouter->post("{ticket}/members", "SupportTicket@attachMembers");
            $objRouter->delete("{ticket}/member", "SupportTicket@detachMember");
            $objRouter->delete("{ticket}/members", "SupportTicket@detachMembers");
        });

        $objRouter->get("correspondences", "Correspondence@getCorrespondences");

        $objRouter->group(["prefix" => "correspondence"], function (Router $objRouter) {
            $objRouter->post("/{correspondence_uuid}/response", "Correspondence@responseForCorrespondence");
            $objRouter->get("/{correspondence_uuid}", "Correspondence@getCorrespondenceByUuid");
            $objRouter->patch("/{correspondence_uuid}", "Correspondence@updateCorrespondenceByUuid");
        });
    });

    /**Office */
    $objRouter->group(["prefix" => "office"], function (Router $objRouter) {
        $objRouter->group(["namespace" => "Office"], function (Router $objRouter) {

            $objRouter->post("contact", "Contact@store");

            $objRouter->group(["middleware" => "auth:api"], function (Router $objRouter) {
                $objRouter->get("contacts", "Contact@getByAccess");
                $objRouter->get("contact/{contact}", "Contact@show");
                $objRouter->patch("contact/{contact}", "Contact@update");
            });
        });

        $objRouter->group(["middleware" => "auth:api"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "user", "namespace" => "Core"], function (Router $objRouter) {
                $objRouter->patch("{user}/alias", "User@addAlias");
                $objRouter->delete("{user}/alias/{alias}", "User@deleteAlias");
                $objRouter->patch("{user}/security", "User@security");
                $objRouter->patch("{user}", "User@update");
            });

            $objRouter->group(["prefix" => "autocomplete"], function (Router $objRouter) {
                $objRouter->group(["namespace" => "Core\Auth"], function (Router $objRouter) {
                    $objRouter->get("groups", "AuthGroup@search");
                });
                $objRouter->group(["namespace" => "Core"], function (Router $objRouter) {
                    $objRouter->get("users", "User@search");
                });
            });

            $objRouter->group(["prefix" => "accounts", "namespace" => "Core\Auth"], function (Router $objRouter) {
                $objRouter->get("groups", "AuthGroup@index");
            });

            $objRouter->group(["prefix" => "soundblock", "namespace" => "Office"], function (Router $objRouter) {
                /* Announcements */
                $objRouter->group(["prefix" => "announcements"], function (Router $objRouter){
                    $objRouter->get("{announcement?}", "Announcement@index");
                    $objRouter->post("", "Announcement@store");
                    $objRouter->patch("{announcement}", "Announcement@update");
                    $objRouter->delete("{announcement}", "Announcement@delete");
                });

                /** Deployments */
                $objRouter->get("deployments", "Deployment@getAllDeployments");
                $objRouter->get("deployment/{deployment}", "Deployment@getDeploymentDetails");
                $objRouter->patch("deployment/{deployment}/update", "Deployment@updateDeployment");
                $objRouter->get("deployment/{deployment}/download", "Deployment@downloadZip");

                /** Accounts */
                $objRouter->group(["prefix" => "account"], function (Router $objRouter) {
                    $objRouter->post("/", "Account@store");
                    $objRouter->patch("/", "Account@update");
                    $objRouter->post("notes", "AccountNote@store");
                    $objRouter->get("notes", "AccountNote@index");
                    $objRouter->get("attachment/{attachment}", "AccountNote@getAttachment");
                });

                /** Account Plans */
                $objRouter->get("accountplans", "AccountPlan@index");

                $objRouter->group(["prefix" => "typeahead"], function (Router $objRouter) {
                    $objRouter->get("account", "AccountPlan@typeahead");
                    $objRouter->get("project", "Project@typeahead");
                    $objRouter->get("artist", "Artist@typeahead");
                });

                $objRouter->group(["prefix" => "accountplan"], function (Router $objRouter) {
                    $objRouter->get("{accountplan}", "AccountPlan@show");
                    $objRouter->post("/", "AccountPlan@store");
                    $objRouter->patch("{accountplan}/day", "AccountPlan@updateDay");
                    $objRouter->patch("{accountplan}/cancel", "AccountPlan@cancel");
                    $objRouter->patch("{user}/change/{account}", "AccountPlan@changeAccountPlanType");
                });

                /** Projects */
                $objRouter->get("projects", "Project@index");

                $objRouter->group(["prefix" => "project"], function (Router $objRouter) {
                    $objRouter->get("{project}/details", "Project@show");
                    $objRouter->post("/", "Project@store");

                    $objRouter->patch("{project}/label", "Project@updateLabel");

                    $objRouter->post("file", "Project@addFile");
                    $objRouter->post("artwork", "Project@artwork");

                    $objRouter->post("{project}/deployment", "Deployment@store");

                    $objRouter->get("{project}/collections", "Collection@index");

                    $objRouter->group(["prefix" => "collection"], function (Router $objRouter){
                        $objRouter->get("/", "Collection@showCollection");
                        $objRouter->get("/{collection}/deployments", "Deployment@getDeploymentsByCollection");
                        $objRouter->patch("/{collection}/deployments", "Deployment@updateCollectionDeployments");
                    });

                    $objRouter->get("{project}/members", "Project@getMembers");
                    $objRouter->post("{project}/member", "Project@addMember");
                    $objRouter->post("{project}/member/user", "Project@createMember");
                    $objRouter->delete("{project}/member/{user}", "Project@deleteMember");

                    $objRouter->get("{project}/notes", "ProjectNote@show");
                    $objRouter->post("notes", "ProjectNote@create");
                    $objRouter->post("notes/upload", "ProjectNote@upload");

                    $objRouter->patch("/{project}/file/{file}/timecodes", "Collection@addFileTimecodes");
                    $objRouter->get("/{project}/file/{file}/timecodes", "Collection@getTimecodes");
                });

                /** Autocomplete */
                $objRouter->group(["prefix" => "autocomplete"], function (Router $objRouter) {
                    $objRouter->get("accounts", "Account@autocomplete");
                    $objRouter->get("projects", "Project@autocomplete");
                    $objRouter->get("projects/accounts", "Project@autocompleteWithAccounts");
                    $objRouter->get("platforms", "Platform@autocomplete");
                });

                $objRouter->post("report", "Report@store");
            });

            $objRouter->group(["prefix" => "accounting", "namespace" => "Office\Accounting"], function (Router $objRouter) {
                $objRouter->group(["prefix" => "charge/rates"], function (Router $objRouter) {
                    $objRouter->get("/", "TypeRates@getCharges");
                    $objRouter->post("/", "TypeRates@saveCharges");
                });
            });
        });

        $objRouter->group(["prefix" => "merch/apparel", "middleware" => "auth:api"], function (Router $objRouter) {
            $objRouter->group(["namespace" => "Office\Merch\Apparel"], function (Router $objRouter) {
                /* SEO */
                $objRouter->patch('seo/{category_uuid}', 'Seo@updateCategory');
                $objRouter->post('seo', 'Seo@updateCategories');
                $objRouter->get("seo", "Seo@getCategories");

                /* Products */
                $objRouter->get("products", "Products@getProducts");

                $objRouter->group(["prefix" => "product"], function (Router $objRouter) {
                    $objRouter->get("/{product_uuid}", "Products@getProductByUuid");
                    $objRouter->delete("/{product_uuid}", "Products@deleteProductByUuid");
                    $objRouter->patch("/{product_uuid}", "Products@editProductByUuid");
                    $objRouter->post("/", "Products@createProduct");

                    /* Product Prices */
                    $objRouter->post("/price", "ProductPrice@createProductPrice");
                    $objRouter->delete("/{product_uuid}/price/{price_uuid}", "ProductPrice@deleteProductPrice");
                    $objRouter->patch("/{product_uuid}/price/{price_uuid}", "ProductPrice@editProductPrice");
                });

                /* Attributes */
                $objRouter->get("{categoty_uuid}/attributes/{attribute_type}", "Attributes@getCategoryAttributesByType");
                $objRouter->post("attribute", "Attributes@createAttribute");
            });
        });

        $objRouter->group(["prefix" => "structure", "middleware" => "auth:api", "namespace" => "Core"], function (Router $objRouter) {
            $objRouter->get("/", "AppsStruct@getAllStructures");
            $objRouter->post("/", "AppsStruct@createStruct");
            $objRouter->get("/prefix/{prefix}", "AppsStruct@getStructureByPrefix");
            $objRouter->get("/{structure}", "AppsStruct@getStructureByUuid");
        });

        $objRouter->group(["prefix" => "accounting"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "invoice", "middleware" => "auth:api", "namespace" => "Office\Accounting"], function (Router $objRouter) {
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

                $objRouter->group(["prefix" => "type/rate"], function (Router $objRouter) {
                    $objRouter->get("/", "TypeRates@getCharges");
                    $objRouter->post("/", "TypeRates@saveCharges");
                    $objRouter->patch("/{type_rate}", "TypeRates@updateTypeRate");
                    $objRouter->delete("/{type_rate}", "TypeRates@deleteTypeRate");
                });
            });
        });

        /* Office Bootloader */
        $objRouter->group(["prefix" => "bootloader", "middleware" => "auth:api", "namespace" => "Office"], function (Router $objRouter) {
            $objRouter->get("/", "Bootloader@getAuthUserGroup");
        });

        $objRouter->group(["prefix" => "music", "namespace" => "Office\Music", "middleware" => "auth:api"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "/autocomplete"], function (Router $objRouter) {
                $objRouter->get("/track/{track}/composers", "Tracks@composersAutocomplete");
                $objRouter->get("/track/{track}/performers", "Tracks@composersAutocomplete");
                $objRouter->get("/artists", "Artists@autocomplete");
                $objRouter->get("/artist/{artist}/members", "Artists@membersAutocomplete");
                $objRouter->get("/genre", "Genres@autocomplete");
                $objRouter->get("/mood", "Moods@autocomplete");
                $objRouter->get("/style", "Styles@autocomplete");
                $objRouter->get("/theme", "Themes@autocomplete");
            });

            $objRouter->get("/artists", "Artists@index");

            $objRouter->group(["prefix" => "/artist"], function (Router $objRouter) {
                $objRouter->get("/{artist}", "Artists@get");
                $objRouter->post("/", "Artists@create");
                $objRouter->patch("/{artist}", "Artists@update");
            });

            $objRouter->get("/projects", "Projects@index");

            $objRouter->group(["prefix" => "project"], function (Router $objRouter) {
                $objRouter->get("/{project}", "Projects@get");
                $objRouter->post("/{project}", "Projects@update");
                $objRouter->delete("/{project}", "Projects@delete");

                $objRouter->group(["prefix" => "{project}/track"], function (Router $objRouter) {
                    $objRouter->get("{track}", "Tracks@show");
                    $objRouter->post("", "Tracks@store");
                    $objRouter->post("{track}/upload", "Tracks@uploadTrack");
                    $objRouter->patch("{track}", "Tracks@update");
                    $objRouter->delete("{track}", "Tracks@delete");
                });
            });

            $objRouter->get("/drafts", "ProjectDraft@getDrafts");

            $objRouter->group(["prefix" => "draft"], function (Router $objRouter) {
                $objRouter->get("/{draft}", "ProjectDraft@getDraft");
                $objRouter->post("/", "ProjectDraft@saveDraft");
                $objRouter->patch("/{draft}", "ProjectDraft@updateDraft");
                $objRouter->delete("/{draft}", "ProjectDraft@removeDraft");
                $objRouter->post("/{draft}/publish", "ProjectDraft@publishDraft");
            });
        });
    });
});

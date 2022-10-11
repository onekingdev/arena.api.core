<?php

use Dingo\Api\Routing\Router;

/** @var Router $objRouter */
$objRouter = app(Router::class);

$objRouter->version("v1", function (Router $objRouter) {

    $objRouter->group(["namespace" => "App\Http\Controllers", "middleware" => ["check.header"]], function (Router $objRouter) {

        /* Authorization Routes */
        $objRouter->group(["prefix" => "core/auth", "namespace" => "Core\Auth"], function(Router $objRouter)
        {

            $objRouter->post("signin",  ["as" => "signin", "uses" => "AuthController@signIn"]);
            $objRouter->post("signup",  "AuthController@signUp");
            $objRouter->patch ("refresh", "AuthController@userRefresh");
            $objRouter->group(["middleware" => "auth:api"], function (Router $objRouter)
            {
                $objRouter->delete("signout", "AuthController@signOut");
            });

            $objRouter->group(["middleware" => "auth:api"], function (Router $objRouter)
            {
                $objRouter->post("check-password", "AuthController@checkPassword");
                $objRouter->post("reset-password", "AuthController@resetPassword");
                $objRouter->get("index", "AuthController@userData");
            });

            /*Add/Remove Group/Memeber */
            $objRouter->group(["prefix" => "access", "middleware" => ["auth:api"]], function(Router $objRouter) {

                $objRouter->post("group", "AuthGroup@createGroup");
                $objRouter->post("users", "AuthGroup@addUsers");
                $objRouter->delete("group", "AuthGroup@deleteGroup");
                $objRouter->delete("users", "AuthGroup@deleteUsersInGroup");
                //Listing all groups
                $objRouter->get("groups", "AuthGroup@indexForOffice");

                //Listing all Permissions
                $objRouter->get("permission", "AuthPermission@show");

                $objRouter->post("permission", "AuthPermission@store");
                $objRouter->get("permissions", "AuthPermission@index");

                $objRouter->group(["prefix" => "permission"], function (Router $objRouter) {

                    $objRouter->patch("group", "AuthPermission@updatePermissionInGroup");
                    $objRouter->patch("user", "AuthPermission@updatePermissionInUser");
                    $objRouter->delete("user", "AuthPermission@deletePermissionInUser");
                });

                //Listing all permissions in a group.
                $objRouter->get("permissions-in-group", "AuthPermission@getPermissionsInGroup");
                //Add permission to a group.
                $objRouter->post("permissions-to-group", "AuthPermission@addPermissionsToGroup");
                //Remove permissions in a group.
                $objRouter->delete("permissions-group", "AuthPermission@deletePermissionsInGroup");
                //Add permissions to a user
                $objRouter->post("permissions-user", "AuthPermission@addPermissionsToUser");
                //Remove permissions from a user
                $objRouter->delete("permissions-user", "AuthPermission@deletePermissionsInUser");

            });

        });

        $objRouter->group(["prefix" => "user", "middleware" => "auth:api"], function(Router $objRouter)
        {
            $objRouter->group(["prefix" => "notifications", "namespace" => "Core"], function(Router $objRouter)
            {
                $objRouter->post("index", "Notification@index");
                $objRouter->get("mark-state", "Notification@markState");
            });

        });

        $objRouter->group(["prefix" => "test", "middleware" => "auth:api"], function(Router $objRouter)
        {

            $objRouter->group(["namespace" => "Core"], function(Router $objRouter)
            {
                $objRouter->get("notifications", "Notification@send");
                $objRouter->get("mail", "Notification@sendMail");
            });

        });

        /**Support */

        $objRouter->group(["namespace" => "Office", "prefix" => "support", "middleware" => "auth:api"], function (Router $objRouter) {

            $objRouter->get("tickets", "SupportController@index");
            $objRouter->post("ticket", "SupportController@store");
            $objRouter->group(["prefix" => "ticket"], function (Router $objRouter) {
                $objRouter->get("messages", "SupportController@getMessages");
            });
        });

        /**Office */
        $objRouter->group(["prefix" => "office", "middleware" => "auth:api"], function(Router $objRouter) {

            $objRouter->group(["namespace" => "Core"], function (Router $objRouter) {
                // To fix.
                $objRouter->get("users", "User@indexForOffice");

                $objRouter->group(["prefix" => "users"], function (Router $objRouter) {
                    $objRouter->get("autocomplete", "User@search");
                });
            });

            $objRouter->group(["prefix" => "services", "namespace" => "Core\Auth"], function(Router $objRouter) {
                //reviewd by @Jin 2020/03/15
                $objRouter->get("groups", "AuthGroup@indexForOffice");
            });

            $objRouter->group(["prefix" => "soundblock"], function(Router $objRouter) {

                $objRouter->group(["namespace" => "Soundblock"], function (Router $objRouter) {

                    //To fix.
                    // $objRouter->get("serviceplans", "ServicePlanController@indexForOffice");

                    //reviewed by @Jin 2020/03/15
                    $objRouter->post("service", "Service@store");
                    //reviewed by @Jin 2020/03/15
                    $objRouter->patch("service", "Service@update");

                    $objRouter->group(["prefix" => "services"], function (Router $objRouter) {

                        $objRouter->get("typeahead", "Service@search");
                    });

                    // service plan
                    $objRouter->get("serviceplans", "Service@index");
                    $objRouter->get("serviceplan", "Service@showForOffice");
                    $objRouter->post("serviceplan", "Service@store");
                    $objRouter->patch("serviceplan", "Service@update");

                    $objRouter->group(["prefix" => "serviceplan"], function (Router $objRouter) {

                        $objRouter->post("notes", "ServiceNote@store");
                        $objRouter->get("notes", "ServiceNote@index");

                        $objRouter->group(["prefix" => "notes"], function (Router $objRouter) {

                        });
                    });
                });

                $objRouter->group(["namespace" => "Office"], function(Router $objRouter) {
                    $objRouter->get("projects", "Project@indexForOffice");
                    $objRouter->get("project", "Project@showForOffice");
                    $objRouter->post("project", "Project@storeForOffice");
                });
                $objRouter->group(["namespace" => "Soundblock"], function(Router $objRouter) {
                    $objRouter->group(["prefix" => "project"], function(Router $objRouter) {

                        $objRouter->post("add-file", "Project@addFile");
                        $objRouter->post("artwork", "Project@artworkForOffice");
                        $objRouter->get("deployment", "Deployment@indexForOffice");
                        $objRouter->patch("deployment", "Deployment@update");
                        $objRouter->get("collections", "Collection@indexForOffice");
                        $objRouter->get("collection", "Collection@showCollection");

                        $objRouter->group(["prefix" => "collection"], function(Router $objRouter) {

                            $objRouter->get("zip", "Collection@zipFiles");
                            $objRouter->get("download", "Collection@downloadFiles");
                        });

                        $objRouter->group(["prefix" => "deployment"], function (Router $objRouter) {
                            // zip request
                            $objRouter->get("collections", "Deployment@getCollections");
                            $objRouter->get("download", "Deployment@download");
                        });

                        $objRouter->post("notes", "ProjectNote@create");
                        $objRouter->get("notes", "ProjectNote@show");
                        $objRouter->group(["prefix" => "notes"], function (Router $objRouter) {
                            $objRouter->post("upload", "ProjectNote@upload");
                        });
                    });

                    $objRouter->group(["prefix" => "projects"], function (Router $objRouter) {
                        $objRouter->post("deployment", "Deployment@storeMultiple");
                    });
                });

            });
        });

        /*Soundblock */
        $objRouter->group(["prefix" => "soundblock", "middleware" => "auth:api"], function(Router $objRouter)
        {


            $objRouter->group(["namespace" => "Soundblock"], function (Router $objRouter)
            {
                /**Bootloader */
                //reviewed by @Jin 2020/03/15.
                $objRouter->get("bootloader", "BootLoader@index");

                //reviewed by @Jin 2020/03/15
                $objRouter->get("platforms", "Platform@index");
            });

            $objRouter->group(["prefix" => "profile", "namespace" => "Account"], function(Router $objRouter) {

                //reviewed by @Jin 2020/03/15
                $objRouter->get("index", "Profile@index");
                //reviewed by @Jin 2020/03/15
                $objRouter->post("phone", "Profile@storePhone");
                //reviewed by @Jin 2020/03/15
                $objRouter->delete("phone", "Profile@deletePhone");
                //reviewed by @Jin 2020/03/15
                $objRouter->post("email", "Profile@storeEmail");
                //reviewed by @Jin 2020/03/15
                $objRouter->delete("email", "Profile@deleteEmail");
                //reviewed by @Jin 2020/03/15
                $objRouter->post("postal", "Profile@storePostal");
                //reviewed by @Jin 2020/03/15
                $objRouter->delete("postal", "Profile@deletePostal");
                //reviewed by @Jin 2020/03/15
                $objRouter->patch("rename", "Profile@rename");

                $objRouter->group(["prefix" => "payment"], function(Router $objRouter)
                {
                    //reviewed by @Jin 2020/03/15
                    $objRouter->post("bank-account", "Profile@storeBankAccount");
                    //reviewed by @Jin 2020/03/15
                    $objRouter->patch("set-primary", "Profile@setPrimary");
                    //reviewed by @Jin 2020/03/15
                    $objRouter->delete("bank-account", "Profile@deleteBankAccount");
                    //reviewed by @Jin 2020/03/15
                    $objRouter->post("paypal", "Profile@storePaypal");
                    //reviewed by @Jin 2020/03/15
                    $objRouter->delete("paypal", "Profile@deletePaypal");
                });
            });

            $objRouter->group(["namespace" => "Soundblock"], function (Router $objRouter) {

                //reviewed by @Jin 2020/03/15
                $objRouter->get("service", ["uses" => "Service@show", "as" => "service"]);
                //reviewed by @Jin 2020/03/15
                $objRouter->get("services", ["uses" => "Service@indexForSoundblock", "as" => "get-services"]);
                //reviewed by @Jin 2020/03/15
                $objRouter->post("service", "Service@store");
                //reviewed by @Jin 2020/03/15
                $objRouter->patch("service", "Service@update");
            });

            /**Project */
            $objRouter->group(["namespace" => "Soundblock"], function(Router $objRouter)
            {
                //reviewed by @Jin 2020/03/15
                $objRouter->get("drafts", "ProjectDraft@index");
                //reviewed by @Jin 2020/03/15
                $objRouter->post("draft", "ProjectDraft@store");

                $objRouter->group(["prefix" => "draft"], function (Router $objRouter) {

                    //reviewed by @Jin 2020/03/15
                    $objRouter->post("artwork", "ProjectDraft@artwork");
                });

                //reviewed by @Jin 2020/03/15
                $objRouter->get("projects", ["uses" => "Project@indexForSoundblock", "as" => "get-projects"]);
                //reviewed by @Jin 2020/03/15
                $objRouter->get("project", "Project@show");
                //reviewed by @Jin 2020/03/15
                $objRouter->post("project", "Project@storeForSoundblock");
                $objRouter->get("show-team", "Project@showTeam");

                $objRouter->get("ping-zip", "Project@pingExtractingZip");
                //reviewed by @Jin 2020/03/15
                $objRouter->group(["prefix" => "project"], function(Router $objRouter)
                {
                    $objRouter->get("collections", "Collection@indexForSoundblock");
                    $objRouter->post("artwork", "Project@artworkForSoundblock");

                    $objRouter->group(["prefix" => "collection"], function (Router $objRouter)
                    {
                        // $objRouter->get("file-history", "FileHistory@index");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->get("tracks", "Collection@getTrackInCollection");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->get("resources", "Collection@showResources");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->post("revert", "Collection@revert");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->post("restore", "Collection@restore");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->post("file", "Collection@addFile");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->patch("files", "Collection@editFiles");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->delete("files", "Collection@deleteFiles");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->post("organize-musics", "Collection@organizeMusics");

                        $objRouter->post("download-files", "Collection@downloadFiles");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->post("directory", "Collection@addDirectory");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->patch("directory", "Collection@editDirectory");
                        //reviewed by @Jin 2020/03/15
                        $objRouter->delete("directory", "Collection@deleteDirectory");

                    });

                    $objRouter->get("deploy", "Deployment@indexForSoundblock");
                    $objRouter->post("deploy", "Deployment@store");
                    $objRouter->patch("deploy", "Deployment@update");
                });
                // $objRouter->delete("destroy", "User@destroy");
            });

            /**Users */
            $objRouter->group(["prefix" => "users", "namespace" => "Core"], function(Router $objRouter) {

                $objRouter->post("add-original-team-members", "User@addOriginalTeamMembers");
                $objRouter->post("add-team-members", "User@addTeamMembers");
            });

            $objRouter->group(["prefix" => "setting"], function (Router $objRouter)
            {
                /**Google 2fa */
                $objRouter->group(["prefix" => "security", "namespace" => "Auth"], function (Router $objRouter)
                {

                });

                /**Account */
                $objRouter->group(["prefix" => "account", "namespace" => "Soundblock"], function (Router $objRouter)
                {
                    $objRouter->get("index", "Service@userService");
                });
            });

        });

        /* Resource Routes */

        $objRouter->group(["middleware" =>  ["auth:api"]], function (Router $objRouter)
        {
            $objRouter->group(["namespace" =>  "Core"], function (Router $objRouter)
            {
                $objRouter->get("users", "User@indexForOffice");
            });
            $objRouter->group(["namespace" =>  "Account"], function (Router $objRouter)
            {
                $objRouter->get("user", "Profile@show");

                $objRouter->group(["prefix" => "user"], function (Router $objRouter) {

                    $objRouter->patch("name", "Profile@updateNameForOffice");
                });
            });
        });

        /* Status Routes */

        $objRouter->group(["prefix" => "status", "namespace" => "Soundblock"], function (Router $objRouter)
        {

            $objRouter->get("ping", "Server@ping");
            $objRouter->get("version", "Server@version");

        });
    });

});

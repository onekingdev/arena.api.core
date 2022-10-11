<?php

use \Illuminate\Routing\Router;

/** @var Router $objRouter */
$objRouter = resolve("router");

$objRouter->group(["middleware" => ["check.header"]], function (Router $objRouter) {

    $objRouter->group(["prefix" => "soundblock", "middleware" => "auth:api"], function (Router $objRouter) {

        $objRouter->group(["namespace" => "Soundblock"], function (Router $objRouter) {
            /**Bootloader */
            $objRouter->get("bootloader", "BootLoader@index");
            $objRouter->get("bootloader-data", "BootLoader@getData");
            $objRouter->get("noteable", "BootLoader@getNoteableEvents");
            $objRouter->get("events", "Event@index");
            $objRouter->patch("event/{event}", "Event@processEvent");
            $objRouter->get("platforms", "Platform@index");
            $objRouter->get("announcements/{announcement?}", "Announcement@index");

            $objRouter->group(["prefix" => "data"], function (Router $objRouter) {
                $objRouter->get("languages", "Data@getLanguages");
                $objRouter->get("contributors", "Data@getContributors");
                $objRouter->get("genres", "Data@getGenres");
            });
        });

        $objRouter->group(["namespace" => "Soundblock"], function (Router $objRouter) {
            $objRouter->get("accounts", ["uses" => "Account@index", "as" => "get-accounts"]);
            $objRouter->get("accounts/user/plans", "Account@getUserAccounts");

            $objRouter->group(["prefix" => "account"], function (Router $objRouter) {
                $objRouter->group(["prefix" => "database"], function (Router $objRouter) {
                    $objRouter->group(["prefix" => "artists"], function (Router $objRouter) {
                        $objRouter->get("", "Artist@index");
                        $objRouter->post("", "Artist@store");
                        $objRouter->patch("", "Artist@update");
                        $objRouter->delete("", "Artist@delete");

                        $objRouter->group(["prefix" => "publisher"], function (Router $objRouter) {
                            $objRouter->get("", "Artist@indexArtistPublisher");
                            $objRouter->post("", "Artist@storeArtistPublisher");
                            $objRouter->patch("", "Artist@updateArtistPublisher");
                            $objRouter->delete("", "Artist@deleteArtistPublisher");
                        });
                    });
                });
            });

            $objRouter->group(["prefix" => "account"], function (Router $objRouter) {
                $objRouter->get("/", "Account@getByProject");
                $objRouter->get("/{account}", ["uses" => "Account@show", "as" => "account"]);
                $objRouter->get("/{account}/transactions", "Account@getAccountTransactions");
                $objRouter->delete("/user/{account}", "Account@deleteAccount");

                $objRouter->patch("/{account}", "Account@updateAccount");
                $objRouter->patch("/", "Account@update");
                $objRouter->delete("/{account}", "Account@detachUser");

                /*
                 * Account Plan Routes
                 * */
                $objRouter->group(["prefix" => "plan"], function (Router $objRouter) {
                    $objRouter->post("create", "AccountPlan@store");
                    $objRouter->patch("update/{account_uuid?}", "AccountPlan@update");
                    $objRouter->post("cancel/{account_uuid?}", "AccountPlan@cancel");
                });

                $objRouter->get("/{account}/projects", "Project@getProjectsByAccount");
            });

            $objRouter->group(["prefix" => "reports"], function (Router $objRouter) {
                $objRouter->get("/account/{account?}", "Account@report");
                $objRouter->get("/account/{account}/disc", "Account@getAccountDiscReports");
                $objRouter->get("/account/{account}/billing", "Account@getAccountBillingsReports");
                //TODO: Remove
                $objRouter->get("/space/account/{account}", "Reports@getAccountReport");
                $objRouter->get("/space/project/{project}", "Reports@getProjectReport");

                $objRouter->get("/usage/account/{account}", "Reports@getAccountReport");
                $objRouter->get("/usage/project/{project}", "Reports@getProjectReport");
            });
        });

        /**Project */
        $objRouter->group(["namespace" => "Soundblock"], function (Router $objRouter) {
            $objRouter->get("drafts", "ProjectDraft@index");
            $objRouter->post("draft", "ProjectDraft@store");

            $objRouter->get("projects", ["uses" => "Project@index", "as" => "get-projects"]);
            $objRouter->delete("projects", "Project@detachUser");
            $objRouter->get("projects/accounts", "Project@getProjectsAccounts");
            $objRouter->get("projects/roles", "Project@getProjectsRoles");
            $objRouter->get("projects/formats", "Project@getProjectsFormats");

            $objRouter->get("ping-zip", "Project@pingExtractingZip");

            $objRouter->group(["prefix" => "project"], function (Router $objRouter) {
                $objRouter->get("/{project}", "Project@show");
                $objRouter->post("/", "Project@store");
                $objRouter->patch("/{project}", "Project@update");

                $objRouter->post("file", "Project@addFile");
                $objRouter->post("confirm", "Project@confirm");
                $objRouter->post("confirm/multiple", "Project@confirmMultiple");
                $objRouter->get("{project}/collections", "Collection@index");
                $objRouter->delete("{project}/collection/directory/{directory}", "Collection@deleteDirectory");
                $objRouter->post("artwork", "Project@artwork");
                $objRouter->post("draft/artwork", "Project@uploadArtworkForDraft");

                $objRouter->get("/{project}/file/{file}", "Collection@playMusicFile");
                $objRouter->patch("/{project}/file/{file}/timecodes", "Collection@addFileTimecodes");
                $objRouter->get("/{project}/file/{file}/timecodes", "Collection@getTimecodes");

                $objRouter->post("/{project}/file/{file}/cover", "Collection@saveTrackCover");

                $objRouter->group(["prefix" => "collection"], function (Router $objRouter) {
                    // $objRouter->get("file-history", "FileHistory@index");
                    $objRouter->get("{collection}/tracks", "Collection@getTrackInCollection");
                    $objRouter->get("{collection}/history", "Collection@getCollectionFilesHistory");
                    $objRouter->get("file/{file}/history", "Collection@getFileHistory");
                    $objRouter->get("track/file/history", "Collection@getTrackHistory");
                    $objRouter->get("{collection}", "Collection@showResources");
                    $objRouter->post("revert", "Collection@revert");
                    $objRouter->post("restore", "Collection@restore");
                    $objRouter->post("upload", "Collection@uploadFiles");
                    $objRouter->post("upload/confirm", "Collection@confirmFiles");
                    $objRouter->patch("files", "Collection@editFiles");
                    $objRouter->delete("files", "Collection@deleteFiles");
                    $objRouter->post("organize-music", "Collection@organizeMusics");
                    $objRouter->get("{collection}/download", "Collection@zipFiles");
                    $objRouter->get("{collection}/directory/{directory}/files", "Collection@directoryFiles");
                    $objRouter->post("directory", "Collection@addDirectory");
                    $objRouter->patch("directory", "Collection@editDirectory");
//                        $objRouter->delete("directory", "Collection@deleteDirectory");
                    $objRouter->group(["prefix" => "file/track"], function (Router $objRouter) {
                        $objRouter->group(["prefix" => "notes"], function (Router $objRouter) {
                            $objRouter->post("", "Track@storeNote");
                            $objRouter->patch("", "Track@updateNote");
                            $objRouter->delete("", "Track@deleteNote");
                        });
                        $objRouter->group(["prefix" => "lyrics"], function (Router $objRouter) {
                            $objRouter->post("", "Track@storeLyrics");
                            $objRouter->patch("", "Track@updateLyrics");
                            $objRouter->delete("", "Track@deleteLyrics");
                        });
                        $objRouter->group(["prefix" => "artists"], function (Router $objRouter) {
                            $objRouter->post("", "Track@storeArtist");
                            $objRouter->delete("", "Track@deleteArtist");
                        });
                        $objRouter->group(["prefix" => "publishers"], function (Router $objRouter) {
                            $objRouter->post("", "Track@storePublisher");
                            $objRouter->delete("", "Track@deletePublisher");
                        });
                        $objRouter->group(["prefix" => "contributors"], function (Router $objRouter) {
                            $objRouter->post("", "Track@storeContributor");
                            $objRouter->delete("", "Track@deleteContributor");
                        });
                        $objRouter->patch("update", "Collection@updateTrackMeta");
                    });
                });

                $objRouter->get("{project}/deployments", "Deployment@index");
                $objRouter->post("{project}/deploy", "Deployment@store");
                $objRouter->patch("{project}/deployment/{deployment}/update", "Deployment@update");

            });
        });

        $objRouter->group(["namespace" => "Soundblock"], function (Router $objRouter) {
            $objRouter->group(["prefix" => "project"], function (Router $objRouter) {
                $objRouter->get("{project}/team", "Team@show");
                $objRouter->post("{project}/team/remind", "Team@remind");
                $objRouter->post("team", "Team@storeMember");
                $objRouter->delete("{project}/team/member/{user}", "Team@deleteMember");
                $objRouter->delete("{project}/team/members", "Team@deleteMembers");
                /* Contract Routes */
                $objRouter->get("{project}/contract", "Contract@get");
                $objRouter->post("{project}/contract", "Contract@store");
                $objRouter->patch("{project}/contract", "Contract@update");
                $objRouter->post("{project}/contract/reminders", "Contract@sendReminders");
                $objRouter->patch("/contract/{contract}/accept", "Contract@accept");
                $objRouter->patch("/contract/{contract}/reject", "Contract@reject");
                $objRouter->patch("/contract/{contract}/cancel", "Contract@cancel");

                $objRouter->group(["prefix" => "team"], function (Router $objRouter) {
                    $objRouter->patch("{team}", "Team@update");
                    $objRouter->get("{team}/user/{user}/permissions", "Team@getPermissions");
                    $objRouter->get("{team}/invite/{invite}/permissions", "Team@getInvitePermissions");
                    $objRouter->patch("{team}/user/{user}/permissions", "Team@updatePermissions");
                    $objRouter->patch("{team}/user/{user}/role", "Team@updateRole");
                    $objRouter->patch("{team}/invite/{invite}/permissions", "Team@updateInvitePermissions");
                });
            });

            $objRouter->get("/invite/hash", "Invite@getInviteHash");

            $objRouter->get("/invites/accounts", "AccountInvite@getInvites");
            $objRouter->post("/invite/account/{account}", "AccountInvite@acceptInvite");
            $objRouter->delete("/invite/account/{account}", "AccountInvite@rejectInvite");
        });

        $objRouter->group(["prefix" => "setting"], function (Router $objRouter) {
            /**Account */
            $objRouter->group(["namespace" => "Soundblock", "prefix" => "account"], function (Router $objRouter) {
                $objRouter->get("/", "Account@userAccount");
            });
        });

        $objRouter->group(["namespace" => "Soundblock", "prefix" => "blockchain"], function (Router $objRouter) {
            $objRouter->get("record/{ledger}", "Blockchain@getPrivate");
        });

    });

    $objRouter->group(["prefix" => "soundblock", "namespace" => "Soundblock"], function (Router $objRouter) {
        $objRouter->group(["prefix" => "invite"], function (Router $objRouter) {
            $objRouter->get("{inviteHash}", "Invite@getInvite");
            $objRouter->post("{inviteHash}/signup", "Invite@signUp");
            $objRouter->post("{inviteHash}/signin", "Invite@signIn");
        });
    });

    $objRouter->group(["prefix" => "soundblock", "namespace" => "Soundblock"], function (Router $objRouter) {
        $objRouter->patch("password-reset/{resetToken}", "AuthController@passwordReset");
//        $objRouter->patch("email/{hash}", "Mail@verifyEmail");
    });
});

$objRouter->group(["prefix" => "soundblock", "namespace" => "Soundblock"], function (Router $objRouter) {
    $objRouter->group(["prefix" => "project/collection", "middleware" => "auth:api"], function (Router $objRouter) {
        $objRouter->get("download/zip/{jobUuid}", "Collection@downloadZipFile");
    });

    $objRouter->get("/project/{project}/artwork", "Project@getArtwork")->name("soundblock.project.artwork");
    $objRouter->get("/project/{project}/file/{file}/cover", "Collection@getTrackCover")->name("soundblock.project.track.cover");
    $objRouter->get("announcements/{announcement?}", "Announcement@index");
    $objRouter->get("account_plans_types", "AccountPlan@getActualPlansTypes");
});

$objRouter->group(["prefix" => "soundblock", "namespace" => "Core\Services\Support", "middleware" => ["check.header", "auth:api"]], function (Router $objRouter) {
    $objRouter->get("user/unread/support", "SupportTicketMessage@getUserUnreadSupportMessages");
});

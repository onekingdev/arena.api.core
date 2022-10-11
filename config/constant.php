<?php

return [
    "cache_ttl" => 10,

    "sort" => [
        "asc", "desc",
    ],

    "soundblock" => [
        "file_action" => [
            "Created", "Modified", "Restored", "Reverted",
            "Deleted",
        ],

        "history_category" => [
            "Music", "Video", "Merch", "Files", "Multiple",
        ],

        "deployment_status" => [
            "pending"   => "Pending",
            "deployed"  => "Deployed",
            "failed"    => "Failed",
            "takedown"  => "Pending takedown",
            "cancelled" => "Cancelled",
            "closed"    => "Closed",
            "rejected"  => "Rejected",
        ],

        "distribution" => [
            0 => "All Territories",
        ],

        "filetype" => [
            0 => "Music",
            1 => "Video",
            2 => "Merch",
            3 => "Files",
        ],

        "project_avatar" => "artwork.png",

        "project_type"             => [
            "Album", "EP", "Single", "Ringtone",
        ],
        "postal_type"              => [
            "Home", "Office", "Billing", "Other",
        ],
        "phone_type"               => [
            "Home", "Cell", "Work", "Other",
        ],
        "account_type"             => [
            "Checking", "Saving",
        ],
        "account_level_permission" => [
            "App.Soundblock.Account.Project.Create",
            "App.Soundblock.Account.Project.Deploy",
            "App.Soundblock.Account.Report.Payments",
            "App.Soundblock.Account.Project.Contract",
        ],
        "project"                  => [
            "permissions" => [
                "App.Soundblock.Account.Project.Create",
                "App.Soundblock.Account.Project.Deploy",
                "App.Soundblock.Account.Report.Payments",
                "App.Soundblock.Account.Project.Contract",
                "App.Soundblock.Project.Member.Create",
                "App.Soundblock.Project.Member.Delete",
            ],
        ],
        "account_plan_cost"        => [
            4.99, 24.99,
        ],

        "file_category"     => [
            "music", "video", "merch", "files",
        ],
        "contract"          => [
            "flag_status" => [
                "Pending", "Active", "Modifying",
            ],
        ],
        "download_path"     => "download",
        "upload_path"       => "upload",
        "platform_category" => ["Music", "Video", "Merchandising"],
    ],

    "support" => [
        "category"       => [
            "Customer Service", "Technical Support", "Feedback",
        ],
        "flag_status"    => [
            "Open", "Closed", "Awaiting User", "Awaiting Support", "Awaiting Customer"
        ],
        "message_status" => [
            "Read", "Unread",
        ],
    ],

    "account" => [
        "flag_status" => [
            "inactive", "active",
        ],
        "permissions" => [
            "App.Soundblock.Account.Project.Create",
            "App.Soundblock.Account.Project.Deploy",
            "App.Soundblock.Account.Report.Payments",
            "App.Soundblock.Account.Project.Contract",
        ],
    ],

    "job" => [
        "flag_status" => [
            "Pending", "Succeeded", "Failed",
        ],
    ],

    "notification" => [
        "state"    => [
            "unread", "read", "archived", "deleted",
        ],
        "setting"  => [
            "play_sound" => true,
            "position"   => [
                "web"    => "top-left",
                "mobile" => "top",
            ],
            "per_page"   => 10,
            "show_time"  => 5,
        ],
        "position" => [
            "web"    => ["top-left", "top-middle", "top-right", "middle-left", "middle-middle", "middle-right", "bottom-left", "bottom-middle", "bottom-right"],
            "mobile" => ["top", "bottom"],
        ],
    ],
    "platform"     => [
        "web", "android", "ios",
    ],

    "project_avatar" => "artwork/default_v2.png",
    "user_avatar"    => "assets/static/avatar_v2.jpg",

    "autocomplete" => [
        "users"  => [
            "allowed_fields"    => [
                "apparel"       => "*",
                "arena"         => "*",
                "catalog"       => "*",
                "io"            => "*",
                "merchandising" => "*",
                "music"         => "*",
                "office"        => "*",
                "soundblock"    => "*",
            ],
            "fields_alias"      => [
                "user"        => "user_uuid",
                "first_name"  => "name_first",
                "middle_name" => "name_middle",
                "last_name"   => "name_last",
                "relations"   => [
                    "emails"  => [
                        "email"   => "user_auth_email",
                        "primary" => "flag_primary",
                    ],
                    "aliases" => [
                        "alias"   => "user_alias",
                        "primary" => "flag_primary",
                    ],
                ],
            ],
            "allowed_relations" => [
                "apparel"       => [
                    "emails"  => "*",
                    "aliases" => "*",
                ],
                "arena"         => [
                    "emails"  => "*",
                    "aliases" => "*",
                ],
                "catalog"       => [
                    "emails"  => "*",
                    "aliases" => "*",
                ],
                "io"            => [
                    "emails"  => "*",
                    "aliases" => "*",
                ],
                "merchandising" => [
                    "emails"  => "*",
                    "aliases" => "*",
                ],
                "music"         => [
                    "emails"  => "*",
                    "aliases" => "*",
                ],
                "office"        => [
                    "emails"  => "*",
                    "aliases" => "*",
                ],
                "soundblock"    => [
                    "emails"  => "*",
                    "aliases" => "*",
                ],
            ],
        ],
        "groups" => [
            "allowed_fields" => [
                "apparel"       => "*",
                "arena"         => "*",
                "catalog"       => "*",
                "io"            => "*",
                "merchandising" => "*",
                "music"         => "*",
                "office"        => "*",
                "soundblock"    => "*",
            ],
            "fields_alias"   => [
                "name"        => "group_name",
                "memo"        => "group_memo",
                "is_critical" => "flag_critical",
                "group"       => "group_uuid",
                "auth"        => "auth_uuid",
            ],
        ],
    ],
    "user"         => [
        "fields_alias" => [
            "alias"    => "user_alias",
            "email"    => "user_auth_email",
            "password" => "user_password",
        ],
    ],

    "apparel" => [
        "file_base_path" => "assets/apparel",
    ],

    "accounting" => [
        "invoice"     => [
            "invoice_type" => [
                "Soundblock.Account.Simple", "Soundblock.Account.Reporting", "Soundblock.Account.Collaboration", "Soundblock.Account.Enterprise",
                "Soundblock.Files.Download", "Soundblock.Account.User",
                "Soundblock.Project.Contract", "Arena.Merch.Apparel.Product",
            ],
            "fields_alias" => [
                "product"   => "description",
                "item_cost" => "unit_amount",
                "cost"      => "amount",
            ],
        ],
        "transaction" => [
            "transaction_type" => [
                "Arena.App.Apparel.Product", "Arena.App.Soundblock.Account.Simple", "Arena.App.Soundblock.Account.Reporting",
                "Arena.App.Soundblock.Account.Collaboration", "Arena.App.Soundblock.Account.Enterprise",
                "Arena.App.Soundblock.Account.User", "Arena.App.Soundblock.Project.Download", "Arena.App.Soundblock.Project.Upload",
            ],
        ],
    ],

    "social" => [
        "instagram" => [
            "media_path"     => [
                "cdn" => "social/instagram/",
                "s3"  => "public/social/instagram/",
            ],
            "file_extension" => "png",
        ],
    ],

    "email" => [
        "soundblock"    => [
            "name"    => "Soundblock",
            "address" => "soundblock@support.arena.com",
        ],
        "office"    => [
            "name"    => "Arena Office",
            "address" => "office@support.arena.com",
        ],
        "apparel"       => [
            "name"    => "Apparel",
            "address" => "apparel@support.arena.com",
        ],
        "embroidery"    => [
            "name"    => "Embroidery",
            "address" => "embroidery@support.arena.com",
        ],
        "facecoverings" => [
            "name"    => "Face coverings",
            "address" => "facecoverings@support.arena.com",
        ],
        "merchandising" => [
            "name"    => "Merchandising",
            "address" => "merchandising@support.arena.com",
        ],
        "prints"        => [
            "name"    => "Prints",
            "address" => "prints@support.arena.com",
        ],
        "screenburning" => [
            "name"    => "Screen burning",
            "address" => "screenburning@support.arena.com",
        ],
        "sewing"        => [
            "name"    => "Sewing",
            "address" => "sewing@support.arena.com",
        ],
        "tourmask"      => [
            "name"    => "Tourmask",
            "address" => "tourmask@support.arena.com",
        ],
    ],
    "music" => [
        "project" => [
            "flag_office_hide" => [
                "purchased", "not purchased", "rejected",
            ],
        ],
    ],
    "sentry" => [
        "sentry_arena_issues_url" => "https://sentry.io/organizations/arenaops/issues/",
        "sentry_arena_api_id" => "5776559"
    ]
];

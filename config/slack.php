<?php

return [
    "channels"   => [
        "action"     => env("SLACK_ACTION_CHANNEL", "notify-github-deploys"),
        "commit"     => env("SLACK_COMMIT_CHANNEL", "notify-github-commits"),
        "exceptions" => env("SLACK_EXCEPTION_CHANNEL", "notify-urgent"),
    ],
    "auth_token" => env("SLACK_AUTH_TOKEN"),
    "github"     => [
        "usernames" => [
            "BStanchevArena"  => "U0194B2263G",
            "haykaz7"         => "U01BKSWUL6L",
            "jintaiarena"     => "U012QH831QE",
            "melnykarena"     => "U015AMW40B0",
            "mmunirarena"     => "U01B2DATHEF",
            "rswfire"         => "UFB72SLDQ",
            "vladgarena"      => "U0161SQP25D",
            "vladkarena"      => "U0107KZQT1C",
            "101Distribution" => "UFBG1C3S9",
        ],
    ],
];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Arena Configuration
    |--------------------------------------------------------------------------
    |
    | Variables are organized by project and branch (develop, staging, web).
    | The following projects are included:
    |  - account
    |  - api
    |    - core
    |    - ledger
    |  - core
    |  - io
    |  - merch
    |    - apparel
    |    - embroidery
    |    - facecoverings
    |    - merchandising
    |    - prints
    |    - screenburning
    |    - sewing
    |    - tourmask
    |  - music
    |  - office
    |  - soundblock
    |  - ux
    |  - www
    |
    */

    "account" => [
        "app" => [
            "name" => "Arena Account",
            "repository" => [
                "name" => "arena.account",
                "url" => "https://github.com/ArenaOps/arena.account"
            ],
            "support" => [
                "name" => "Arena Support",
                "email" => "hello@support.arena.com"
            ],
        ],
        "develop" => [
            "app" => [
                "url" => "https://develop.account.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-account-develop",
                    "url" => "https://arena-account.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E1QLH6JFO9KUY3",
                    "domain" => "https://dplaog5uvjnxd.cloudfront.net/",
                    "url" => "https://cloud.develop.account.arena.com/"
                ],
                "eb" => [
                    "id" => "E-SGEFEGKMA3",
                    "name" => "Arena.Account.Develop",
                    "environment" => "Arena-Account-Develop",
                    "url" => "https://arena-account.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "staging" => [
            "app" => [
                "url" => "https://staging.account.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-account-staging",
                    "url" => "https://arena-account-staging.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E1AU2I79TWC7DZ",
                    "domain" => "https://djirrd15m0t8a.cloudfront.net/",
                    "url" => "https://cloud.staging.account.arena.com/"
                ],
                "eb" => [
                    "id" => "E-TUPTPRZFQ3",
                    "name" => "Arena.Account.Staging",
                    "environment" => "Arena-Account-Staging",
                    "url" => "https://arena-account-staging.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "web" => [
            "app" => [
                "url" => "https://account.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-account",
                    "url" => "https://arena-account.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E1CUQQE3K8YDXS",
                    "domain" => "https://d1mez1nl0ytu2z.cloudfront.net/",
                    "url" => "https://cloud.account.arena.com/"
                ],
                "eb" => [
                    "id" => "E-SGEFEGKMA3",
                    "name" => "Arena.Account",
                    "environment" => "Arena-Account",
                    "url" => "https://arena-account.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ]
    ],
    "api" => [
        "core" => [
            "app" => [
                "name" => "Arena Core API",
                "repository" => [
                    "name" => "arena.api.core",
                    "url" => "https://github.com/ArenaOps/arena.api.core"
                ],
                "support" => [
                    "name" => "Arena Support",
                    "email" => "hello@support.arena.com"
                ],
            ],
            "develop" => [
                "app" => [
                    "url" => "https://develop.core.api.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-api-core-develop",
                        "url" => "https://arena-api-core-develop.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E3V18ZHTZI3HH4",
                        "domain" => "https://d3cd3xtyvaynkx.cloudfront.net/",
                        "url" => "https://cloud.develop.api.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-G32UVZXIQH",
                        "name" => "Arena.Api.Core.Develop",
                        "environment" => "Arena-Api-Core-Develop",
                        "url" => "https://arena-api-core-develop.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "staging" => [
                "app" => [
                    "url" => "https://staging.core.api.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-api-core-staging",
                        "url" => "https://arena-api-core-staging.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E2X29AX84NXXSK",
                        "domain" => "https://d72z6n3nqsurt.cloudfront.net/",
                        "url" => "https://cloud.staging.api.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-MIGPXSUIRP",
                        "name" => "Arena.Api.Core.Staging",
                        "environment" => "Arena-Api-Core-Staging",
                        "url" => "https://arena-api-core-staging.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "web" => [
                "app" => [
                    "url" => "https://core.api.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-api-core",
                        "url" => "https://arena-api-core.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E1K66HMEU9QN0A",
                        "domain" => "https://dm36uk89un0y4.cloudfront.net/",
                        "url" => "https://cloud.api.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-XKNG59NJUS",
                        "name" => "Arena.Api.Core",
                        "environment" => "Arena-Api-Core",
                        "url" => "https://arena-api-core.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ]
        ],
        "ledger" => [
            "app" => [
                "name" => "Arena Ledger API",
                "repository" => [
                    "name" => "arena.api.ledger",
                    "url" => "https://github.com/ArenaOps/arena.api.ledger"
                ],
                "support" => [
                    "name" => "Arena Support",
                    "email" => "hello@support.arena.com"
                ],
            ],
            "develop" => [
                "app" => [
                    "url" => "https://develop.ledger.api.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-api-ledger-develop",
                        "url" => "https://arena-api-ledger-develop.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "EMYN6IQQ83DZ9",
                        "domain" => "https://d2ptiy0433fbqq.cloudfront.net/",
                        "url" => "https://cloud.develop.ledger.api.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-4AMVAUNPCY",
                        "name" => "Arena.Api.Ledger.Develop",
                        "environment" => "Arena-Api-Ledger-Develop",
                        "url" => "https://arena-api-ledger-develop.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "staging" => [
                "app" => [
                    "url" => "https://staging.ledger.api.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-api-ledger-staging",
                        "url" => "https://arena-api-ledger-staging.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E2ZUFSVQ2AALFA",
                        "domain" => "https://d2miurvzot1d40.cloudfront.net/",
                        "url" => "https://cloud.staging.ledger.api.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-5QTS2ZN7XK",
                        "name" => "Arena.Api.Ledger.Staging",
                        "environment" => "Arena-Api-Ledger-Staging",
                        "url" => "https://arena-api-ledger-staging.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "web" => [
                "app" => [
                    "url" => "https://ledger.api.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-api-ledger",
                        "url" => "https://arena-api-ledger.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E1590RZSDZDPAM",
                        "domain" => "https://d1z5z02tpki4lx.cloudfront.net/",
                        "url" => "https://cloud.ledger.api.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-APXMRKNTSU",
                        "name" => "Arena.Api.Ledger",
                        "environment" => "Arena-Api-Ledger",
                        "url" => "https://arena-api-ledger.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ]
        ]
    ],
    "core" => [
        "app" => [
            "name" => "Arena Core",
            "repository" => [
                "name" => "arena.core",
                "url" => "https://github.com/ArenaOps/arena.core"
            ],
            "support" => [
                "name" => "Arena",
                "email" => "hello@support.arena.com"
            ],
        ],
        "develop" => [
            "app" => [
                "url" => "https://develop.core.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-core-develop",
                    "url" => "https://arena-core-develop.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E2IUU9EM0Q483R",
                    "domain" => "https://d1xv9634z9i30q.cloudfront.net/",
                    "url" => "https://cloud.develop.core.arena.com/"
                ]
            ]
        ],
        "staging" => [
            "app" => [
                "url" => "https://staging.core.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-core-staging",
                    "url" => "https://arena-core-staging.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E4E0154WDMIWH",
                    "domain" => "https://d2s6keahphgw10.cloudfront.net/",
                    "url" => "https://cloud.staging.core.arena.com/"
                ]
            ]
        ],
        "web" => [
            "app" => [
                "url" => "https://core.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-core",
                    "url" => "https://arena-core-staging.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E1CH9MSPQW356Q",
                    "domain" => "https://d1enqetkh3u8u9.cloudfront.net/",
                    "url" => "https://cloud.core.arena.com/"
                ]
            ]

        ]
    ],
    "io" => [
        "app" => [
            "name" => "Arena IO",
            "repository" => [
                "name" => "arena.io",
                "url" => "https://github.com/ArenaOps/arena.io"
            ],
            "support" => [
                "name" => "Arena Support",
                "email" => "hello@support.arena.com"
            ],
        ],
        "develop" => [
            "app" => [
                "url" => "https://develop.io.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-io-develop",
                    "url" => "https://arena-io-develop.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E17YLVYW6L6FH",
                    "domain" => "https://d2wtozsrhkr35q.cloudfront.net/",
                    "url" => "https://cloud.develop.io.arena.com/"
                ],
                "eb" => [
                    "id" => "E-ENPIAGEZVP",
                    "name" => "Arena.Io.Develop",
                    "environment" => "Arena-Io-Develop",
                    "url" => "https://arena-io-develop.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "staging" => [
            "app" => [
                "url" => "https://staging.io.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-io-staging",
                    "url" => "https://arena-io-staging.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E1O1OF9GMB86PI",
                    "domain" => "https://dh8bnxrl0t4p6.cloudfront.net/",
                    "url" => "https://cloud.apparel.arena.com/"
                ],
                "eb" => [
                    "id" => "E-JSPYH9JUXC",
                    "name" => "Arena.Io.Staging",
                    "environment" => "Arena-Io-Staging",
                    "url" => "https://arena-io-staging.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "web" => [
            "app" => [
                "url" => "https://io.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-io",
                    "url" => "https://arena-io.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E39Q8WM2ZI9XAN",
                    "domain" => "https://d3pmm9q45nqvo4.cloudfront.net/",
                    "url" => "https://cloud.io.arena.com/"
                ],
                "eb" => [
                    "id" => "E-JC95M6YPT6",
                    "name" => "Arena.Io",
                    "environment" => "Arena-Io",
                    "url" => "https://arena-io.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ]
    ],
    "merch" => [
        "apparel" => [
            "app" => [
                "name" => "Arena Apparel",
                "repository" => [
                    "name" => "merch.apparel",
                    "url" => "https://github.com/ArenaOps/merch.apparel"
                ],
                "support" => [
                    "name" => "Arena Apparel",
                    "email" => "apparel@support.arena.com"
                ],
            ],
            "develop" => [
                "app" => [
                    "url" => "https://develop.apparel.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-apparel-develop",
                        "url" => "https://arena-merch-apparel-develop.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E64M22CX1QNZB",
                        "domain" => "https://d3r3bhk8e75aue.cloudfront.net/",
                        "url" => "https://cloud.develop.apparel.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-UMDXBPHEGQ",
                        "name" => "Arena.Merch.Apparel.Develop",
                        "environment" => "Arena-Merch-Apparel-Develop",
                        "url" => "https://arena-merch-apparel-develop.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "staging" => [
                "app" => [
                    "url" => "https://staging.apparel.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-apparel-staging",
                        "url" => "https://arena-merch-apparel-staging.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E22WJ6IKX34YJ1",
                        "domain" => "https://d3cln0uqwdph8t.cloudfront.net/",
                        "url" => "https://cloud.staging.apparel.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-BTJTGZFKRD",
                        "name" => "Arena.Merch.Apparel.Staging",
                        "environment" => "Arena-Merch-Apparel-Staging",
                        "url" => "https://arena-merch-apparel-staging.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "web" => [
                "app" => [
                    "url" => "https://apparel.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-apparel",
                        "url" => "https://arena-merch-apparel.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E30OIR7U2DAOGY",
                        "domain" => "https://d32foe4gotvvjf.cloudfront.net/",
                        "url" => "https://cloud.apparel.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-GC6QWE79WF",
                        "name" => "Arena.Merch.Apparel",
                        "environment" => "Arena-Merch-Apparel",
                        "url" => "https://arena-merch-apparel.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ]
        ],
        "embroidery" => [
            "app" => [
                "name" => "Arena Embroidery",
                "repository" => [
                    "name" => "merch.embroidery",
                    "url" => "https://github.com/ArenaOps/merch.embroidery"
                ],
                "support" => [
                    "name" => "Arena Embroidery",
                    "email" => "embroidery@support.arena.com"
                ],
            ],
            "develop" => [
                "app" => [
                    "url" => "https://develop.embroidery.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-embroidery-develop",
                        "url" => "https://arena-merch-embroidery-develop.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E11LVEAA501LSY",
                        "domain" => "https://dy2soiiy5hraj.cloudfront.net/",
                        "url" => "https://cloud.develop.embroidery.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-WPKSJ5Z3TM",
                        "name" => "Arena.Merch.Embroidery.Develop",
                        "environment" => "Arena-Merch-Embroidery-Develop",
                        "url" => "https://arena-merch-embrodery-develop.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "staging" => [
                "app" => [
                    "url" => "https://staging.embroidery.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-embroidery-staging",
                        "url" => "https://arena-merch-embroidery-staging.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E3CX711Z942PIP",
                        "domain" => "https://d1ij5874di45y0.cloudfront.net/",
                        "url" => "https://cloud.staging.embroidery.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-A3AVEPEHUG",
                        "name" => "Arena.Merch.Embroidery.Staging",
                        "environment" => "Arena-Merch-Embroidery-Staging",
                        "url" => "https://arena-merch-embroidery-staging.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "web" => [
                "app" => [
                    "url" => "https://embroidery.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-embroidery",
                        "url" => "https://arena-merch-embroidery.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E2ENYGXK7TC94C",
                        "domain" => "https://d1k7dqjynn3kgl.cloudfront.net/",
                        "url" => "https://cloud.embroidery.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-H8TEESBB2N",
                        "name" => "Arena.Merch.Embroidery",
                        "environment" => "Arena-Merch-Embroidery",
                        "url" => "https://arena-merch-embroidery.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ]
        ],
        "facecoverings" => [
            "app" => [
                "name" => "Arena Face Coverings",
                "repository" => [
                    "name" => "merch.facecoverings",
                    "url" => "https://github.com/ArenaOps/merch.facecoverings"
                ],
                "support" => [
                    "name" => "Arena Face Coverings",
                    "email" => "facecoverings@support.arena.com"
                ],
            ],
            "develop" => [
                "app" => [
                    "url" => "https://develop.facecoverings.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-facecoverings-develop",
                        "url" => "https://arena-merch-facecoverings-develop.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E3AAUL0BMMAPPT",
                        "domain" => "https://d38botts0er0t6.cloudfront.net/",
                        "url" => "https://cloud.develop.facecoverings.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-BKGW22VHZH",
                        "name" => "Arena.Merch.FaceCoverings.Develop",
                        "environment" => "Arena-Merch-FaceCoverings-Develop",
                        "url" => "https://arena-merch-facecoverings-develop.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "staging" => [
                "app" => [
                    "url" => "https://staging.facecoverings.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-facecoverings-staging",
                        "url" => "https://arena-merch-facecoverings-staging.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E2HGSKSJ232ITK",
                        "domain" => "https://diyym8awgqccm.cloudfront.net/",
                        "url" => "https://cloud.staging.facecoverings.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-XQX4AUCA7G",
                        "name" => "Arena.Merch.FaceCoverings.Staging",
                        "environment" => "Arena-Merch-FaceCoverings-Staging",
                        "url" => "https://arena-merch-facecoverings-staging.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "web" => [
                "app" => [
                    "url" => "https://facecoverings.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-facecoverings",
                        "url" => "https://arena-merch-facecoverings.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E3EGBQSUNOFUMD",
                        "domain" => "https://d3gqy6hsebh85.cloudfront.net/",
                        "url" => "https://cloud.facecoverings.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-YPST2ME3X4",
                        "name" => "Arena.Merch.FaceCoverings",
                        "environment" => "Arena-Merch-FaceCoverings",
                        "url" => "https://arena-merch-facecoverings.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ]
        ],
        "merchandising" => [
            "app" => [
                "name" => "Arena Merchandising",
                "repository" => [
                    "name" => "merch.merchandising",
                    "url" => "https://github.com/ArenaOps/merch.merchandising"
                ],
                "support" => [
                    "name" => "Arena Merchandising",
                    "email" => "merchandising@support.arena.com"
                ],
            ],
            "develop" => [
                "app" => [
                    "url" => "https://develop.merchandising.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-merchandising-develop",
                        "url" => "https://arena-merch-merchandising-develop.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "EM1S7SUXVSPBN",
                        "domain" => "https://d1ofmwg2x8v9hw.cloudfront.net/",
                        "url" => "https://cloud.develop.merchandising.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-MG2NFK8986",
                        "name" => "Arena.Merch.Merchandising.Develop",
                        "environment" => "Arena-Merch-Merchandising-Develop",
                        "url" => "https://arena-merch-merchandising-develop.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "staging" => [
                "app" => [
                    "url" => "https://staging.merchandising.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-merchandising-staging",
                        "url" => "https://arena-merch-merchandising-staging.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E18QEQSZOSR8TS",
                        "domain" => "https://d2fme3knciszhr.cloudfront.net/",
                        "url" => "https://cloud.staging.merchandising.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-PYE2FVXEU3",
                        "name" => "Arena.Merch.Merchandising.Staging",
                        "environment" => "Arena-Merch-Merchandising-Staging",
                        "url" => "https://arena-merch-merchandising-staging.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "web" => [
                "app" => [
                    "url" => "https://merchandising.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-merchandising",
                        "url" => "https://arena-merch-merchandising.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "EFFRETZERLVDH",
                        "domain" => "https://d1gj86uqabg9lc.cloudfront.net/",
                        "url" => "https://cloud.merchandising.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-TRU9MCB2QG",
                        "name" => "Arena.Merch.Merchandising",
                        "environment" => "Arena-Merch-Merchandising",
                        "url" => "https://arena-merch-merchandising.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ]
        ],
        "prints" => [
            "app" => [
                "name" => "Arena Prints",
                "repository" => [
                    "name" => "merch.prints",
                    "url" => "https://github.com/ArenaOps/merch.prints"
                ],
                "support" => [
                    "name" => "Arena Prints",
                    "email" => "prints@support.arena.com"
                ],
            ],
            "develop" => [
                "app" => [
                    "url" => "https://develop.prints.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-prints-develop",
                        "url" => "https://arena-merch-prints-develop.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E2NLOR5W16SU9R",
                        "domain" => "https://d2n9pxaag4w1f5.cloudfront.net/",
                        "url" => "https://cloud.develop.prints.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-FW52RNTQMM",
                        "name" => "Arena.Merch.Prints.Develop",
                        "environment" => "Arena-Merch-Prints-Develop",
                        "url" => "https://arena-merch-prints-develop.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "staging" => [
                "app" => [
                    "url" => "https://staging.prints.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-prints-staging",
                        "url" => "https://arena-merch-prints-staging.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E1N7G6YE2RJ6TO",
                        "domain" => "https://d1b27v2dgqv02m.cloudfront.net/",
                        "url" => "https://cloud.staging.prints.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-M53EKCRVG5",
                        "name" => "Arena.Merch.Prints.Staging",
                        "environment" => "Arena-Merch-Prints-Staging",
                        "url" => "https://arena-merch-prints-staging.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "web" => [
                "app" => [
                    "url" => "https://prints.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-prints",
                        "url" => "https://arena-merch-prints.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E258Z0X727N5GL",
                        "domain" => "https://dqm1gowsbsy4h.cloudfront.net/",
                        "url" => "https://cloud.prints.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-MU8TQJFNKP",
                        "name" => "Arena.Merch.Prints",
                        "environment" => "Arena-Merch-Prints",
                        "url" => "https://arena-merch-prints.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ]
        ],
        "screenburning" => [
            "app" => [
                "name" => "Arena Screen Burning",
                "repository" => [
                    "name" => "merch.screenburning",
                    "url" => "https://github.com/ArenaOps/merch.screenburning"
                ],
                "support" => [
                    "name" => "Arena Screen Burning",
                    "email" => "screenburning@support.arena.com"
                ],
            ],
            "develop" => [
                "app" => [
                    "url" => "https://develop.screenburning.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-screenburning-develop",
                        "url" => "https://arena-merch-screenburning-develop.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "ESBPZERPPMBBX",
                        "domain" => "https://d1oww03m7b7ww2.cloudfront.net/",
                        "url" => "https://cloud.develop.screenburning.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-JDDF2B5MU3",
                        "name" => "Arena.Merch.ScreenBurning.Develop",
                        "environment" => "Arena-Merch-ScreenBurning-Develop",
                        "url" => "https://arena-merch-screenburning-develop.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "staging" => [
                "app" => [
                    "url" => "https://staging.screenburning.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-screenburning-staging",
                        "url" => "https://arena-merch-screenburning-staging.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E1D5FJS1HD81Q2",
                        "domain" => "https://d2nckfm3f9ss28.cloudfront.net/",
                        "url" => "https://cloud.staging.screenburning.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-3TMZAKKGGP",
                        "name" => "Arena.Merch.ScreenBurning.Staging",
                        "environment" => "Arena-Merch-ScreenBurning-Staging",
                        "url" => "https://arena-merch-screenburning-staging.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "web" => [
                "app" => [
                    "url" => "https://screenburning.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-screenburning",
                        "url" => "https://arena-merch-screenburning.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E102BN7JOD9UCK",
                        "domain" => "https://d18fd050jctw5g.cloudfront.net/",
                        "url" => "https://cloud.screenburning.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-A3ZQJIV3CA",
                        "name" => "Arena.Merch.ScreenBurning",
                        "environment" => "Arena-Merch-ScreenBurning",
                        "url" => "https://arena-merch-screenburning.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ]
        ],
        "sewing" => [
            "app" => [
                "name" => "Arena Sewing",
                "repository" => [
                    "name" => "merch.sewing",
                    "url" => "https://github.com/ArenaOps/merch.sewing"
                ],
                "support" => [
                    "name" => "Arena Sewing",
                    "email" => "sewing@support.arena.com"
                ],
            ],
            "develop" => [
                "app" => [
                    "url" => "https://develop.sewing.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-sewing-develop",
                        "url" => "https://arena-merch-sewing-develop.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E4CJ8UYP9XMLQ",
                        "domain" => "https://drw15wrp3wxh0.cloudfront.net/",
                        "url" => "https://cloud.develop.sewing.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-96VFMHCUAW",
                        "name" => "Arena.Merch.Sewing.Develop",
                        "environment" => "Arena-Merch-Sewing-Develop",
                        "url" => "https://arena-merch-sewing-develop.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "staging" => [
                "app" => [
                    "url" => "https://staging.sewing.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-sewing-staging",
                        "url" => "https://arena-merch-sewing-staging.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E1H9LUMHSK626M",
                        "domain" => "https://d505mctxrx7qr.cloudfront.net/",
                        "url" => "https://cloud.staging.sewing.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-X9CWMPS3ZK",
                        "name" => "Arena.Merch.Sewing.Staging",
                        "environment" => "Arena-Merch-Sewing-Staging",
                        "url" => "https://arena-merch-sewing-staging.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "web" => [
                "app" => [
                    "url" => "https://sewing.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-sewing",
                        "url" => "https://arena-merch-sewing.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E25PC214RN54GX",
                        "domain" => "https://drw15wrp3wxh0.cloudfront.net/",
                        "url" => "https://cloud.sewing.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-HBH2PQPGTM",
                        "name" => "Arena.Merch.Sewing",
                        "environment" => "Arena-Merch-Sewing",
                        "url" => "https://arena-merch-sewing.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ]
        ],
        "tourmask" => [
            "app" => [
                "name" => "Arena Tour Mask",
                "repository" => [
                    "name" => "merch.tourmask",
                    "url" => "https://github.com/ArenaOps/merch.tourmask"
                ],
                "support" => [
                    "name" => "Arena Tour Mask",
                    "email" => "tourmask@support.arena.com"
                ],
            ],
            "develop" => [
                "app" => [
                    "url" => "https://develop.tourmask.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-tourmask-develop",
                        "url" => "https://arena-merch-tourmask-develop.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "EY09S550JFRF0",
                        "domain" => "https://d2yogee3w6bnup.cloudfront.net/",
                        "url" => "https://cloud.develop.tourmask.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-CCE5M34TXG",
                        "name" => "Arena.Merch.TourMask.Develop",
                        "environment" => "Arena-Merch-TourMask-Develop",
                        "url" => "https://arena-merch-tourmask-develop.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "staging" => [
                "app" => [
                    "url" => "https://staging.tourmask.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-tourmask-staging",
                        "url" => "https://arena-merch-tourmask-staging.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "EAWEFRSXU7U8L",
                        "domain" => "https://d2k2wc1ryi45aw.cloudfront.net/",
                        "url" => "https://cloud.staging.tourmask.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-YJWNWIWG5P",
                        "name" => "Arena.Merch.TourMask.Staging",
                        "environment" => "Arena-Merch-TourMask-Staging",
                        "url" => "https://arena-merch-tourmask-staging.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ],
            "web" => [
                "app" => [
                    "url" => "https://tourmask.arena.com/"
                ],
                "aws" => [
                    "bucket" => [
                        "name" => "arena-merch-tourmask",
                        "url" => "https://arena-merch-tourmask.s3.amazonaws.com/"
                    ],
                    "cloud" => [
                        "id" => "E3GXAAWJ83GVU",
                        "domain" => "https://d1av5dk9ukuarg.cloudfront.net/",
                        "url" => "https://cloud.tourmask.arena.com/"
                    ],
                    "eb" => [
                        "id" => "E-X863AGPICE",
                        "name" => "Arena.Merch.TourMask",
                        "environment" => "Arena-Merch-TourMask",
                        "url" => "https://arena-merch-tourmask.us-east-1.elasticbeanstalk.com/"
                    ]
                ]
            ]
        ]
    ],
    "music" => [
        "app" => [
            "name" => "Arena Music",
            "repository" => [
                "name" => "arena.music",
                "url" => "https://github.com/ArenaOps/arena.music"
            ],
            "support" => [
                "name" => "Arena Music",
                "email" => "music@support.arena.com"
            ],
        ],
        "develop" => [
            "app" => [
                "url" => "https://develop.music.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-music-develop",
                    "url" => "https://arena-music-develop.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E2C5SE2AXKH0C2",
                    "domain" => "https://d37g5klnm1teay.cloudfront.net/",
                    "url" => "https://cloud.develop.music.arena.com/"
                ],
                "eb" => [
                    "id" => "E-YWNP24WRMV",
                    "name" => "Arena.Music.Develop",
                    "environment" => "Arena-Music-Develop",
                    "url" => "https://arena-music-develop.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "staging" => [
            "app" => [
                "url" => "https://staging.music.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-music-staging",
                    "url" => "https://arena-music-staging.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E3MFVODD6XRYVU",
                    "domain" => "https://d2qe571i081ked.cloudfront.net/",
                    "url" => "https://cloud.staging.music.arena.com/"
                ],
                "eb" => [
                    "id" => "E-TAHCXK8ZS7",
                    "name" => "Arena.Music.Staging",
                    "environment" => "Arena-Music-Staging",
                    "url" => "https://arena-music-staging.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "web" => [
            "app" => [
                "url" => "https://music.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-music",
                    "url" => "https://arena-music.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E23JWTDX8PV5KL",
                    "domain" => "https://duhvh85f599bf.cloudfront.net/",
                    "url" => "https://cloud.music.arena.com/"
                ],
                "eb" => [
                    "id" => "E-ZEQ2W6EEA5",
                    "name" => "Arena.Music",
                    "environment" => "Arena-Music",
                    "url" => "https://arena-music.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ]
    ],
    "office" => [
        "app" => [
            "name" => "Arena Office",
            "repository" => [
                "name" => "arena.office",
                "url" => "https://github.com/ArenaOps/arena.office"
            ],
            "support" => [
                "name" => "Arena Office",
                "email" => "office@support.arena.com"
            ],
        ],
        "develop" => [
            "app" => [
                "url" => "https://develop.office.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-office-develop",
                    "url" => "https://arena-office-develop.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E3JI0FNMNXRFHT",
                    "domain" => "https://d1sb70fl0hcw5y.cloudfront.net/",
                    "url" => "https://cloud.develop.office.arena.com/"
                ],
                "eb" => [
                    "id" => "E-MXIWDSZPZ4",
                    "name" => "Arena.Office.Develop",
                    "environment" => "Arena-Office-Develop",
                    "url" => "https://arena-office-develop.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "staging" => [
            "app" => [
                "url" => "https://staging.office.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-office-staging",
                    "url" => "https://arena-office-staging.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E3SEFUVYGKVFIL",
                    "domain" => "https://d3nvc2of4o7ocy.cloudfront.net/",
                    "url" => "https://cloud.staging.office.arena.com/"
                ],
                "eb" => [
                    "id" => "E-Z3R7TEQM8F",
                    "name" => "Arena.Office.Staging",
                    "environment" => "Arena-Office-Staging",
                    "url" => "https://arena-office-staging.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "web" => [
            "app" => [
                "url" => "https://office.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-office",
                    "url" => "https://arena-office.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E30DRF27HZ4GXB",
                    "domain" => "https://d3a5e9h51e1gw3.cloudfront.net/",
                    "url" => "https://cloud.office.arena.com/"
                ],
                "eb" => [
                    "id" => "E-WMZUENBEVZ",
                    "name" => "Arena.Office",
                    "environment" => "Arena-Office",
                    "url" => "https://arena-office.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ]
    ],
    "ux" => [
        "app" => [
            "name" => "Arena UX",
            "repository" => [
                "name" => "arena.ux",
                "url" => "https://github.com/ArenaOps/arena.ux"
            ],
            "support" => [
                "name" => "Arena UX",
                "email" => "ux@support.arena.com"
            ],
        ],
        "develop" => [
            "app" => [
                "url" => "https://develop.ux.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-ux-develop",
                    "url" => "https://arena-ux-develop.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E3EA4TMX00FFKZ",
                    "domain" => "https://d26xebpj7wenp4.cloudfront.net/",
                    "url" => "https://cloud.develop.ux.arena.com/"
                ],
                "eb" => [
                    "id" => "E-N9WF2FCADM",
                    "name" => "Arena.Ux.Develop",
                    "environment" => "Arena-Ux-Develop",
                    "url" => "https://arena-ux-develop.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "staging" => [
            "app" => [
                "url" => "https://staging.ux.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-ux-staging",
                    "url" => "https://arena-ux-staging.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E2Q38HCJZMUWX5",
                    "domain" => "https://dxvujkkxlpaic.cloudfront.net/",
                    "url" => "https://cloud.staging.ux.arena.com/"
                ],
                "eb" => [
                    "id" => "E-FEWIMBNMDK",
                    "name" => "Arena.Ux.Staging",
                    "environment" => "Arena-Ux-Staging",
                    "url" => "https://arena-ux-staging.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "web" => [
            "app" => [
                "url" => "https://ux.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-ux",
                    "url" => "https://arena-ux.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "EHD89CMYCY0HS",
                    "domain" => "https://d3iqjv0el4gjap.cloudfront.net/",
                    "url" => "https://cloud.ux.arena.com/"
                ],
                "eb" => [
                    "id" => "E-UDHPY3JGEU",
                    "name" => "Arena.Ux",
                    "environment" => "Arena-Ux",
                    "url" => "https://arena-ux.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ]
    ],
    "www" => [
        "app" => [
            "name" => "Arena",
            "repository" => [
                "name" => "arena.web",
                "url" => "https://github.com/ArenaOps/arena.web"
            ],
            "support" => [
                "name" => "Arena",
                "email" => "hello@support.arena.com"
            ],
        ],
        "aws" => [
            "develop" => [
                "app" => [
                    "url" => "https://develop.arena.com/"
                ],
                "bucket" => [
                    "name" => "arena-web-develop",
                    "url" => "https://arena-web-develop.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E3V5VGT0QRUN2L",
                    "domain" => "https://d179ddv4hxln5w.cloudfront.net/",
                    "url" => "https://cloud.develop.arena.com/"
                ],
                "eb" => [
                    "id" => "E-SZTNHHZZNN",
                    "name" => "Arena.Web.Develop",
                    "environment" => "Arena-Web-Develop",
                    "url" => "https://arena-web-develop.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "staging" => [
            "app" => [
                "url" => "https://staging.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-web-staging",
                    "url" => "https://arena-web-staging.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "EBUZ2SUEYKDVP",
                    "domain" => "https://demhdf4l00pxm.cloudfront.net/",
                    "url" => "https://cloud.staging.arena.com/"
                ],
                "eb" => [
                    "id" => "E-UC7DP4PFC4",
                    "name" => "Arena.Web.Staging",
                    "environment" => "Arena-Web-Staging",
                    "url" => "https://arena-web-staging.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "web" => [
            "app" => [
                "url" => "https://arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-web",
                    "url" => "https://arena-web.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E3LNO8E7DMA46U",
                    "domain" => "https://d300kbxb9n6666.cloudfront.net/",
                    "url" => "https://cloud.arena.com/"
                ],
                "eb" => [
                    "id" => "E-MAPQTMNMZZ",
                    "name" => "Arena.Web",
                    "environment" => "Arena-Web",
                    "url" => "https://arena-web.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ]
    ],
    "soundblock" => [
        "app" => [
            "name" => "Soundblock",
            "repository" => [
                "name" => "soundblock.console",
                "url" => "https://github.com/ArenaOps/soundblock.console"
            ],
            "support" => [
                "name" => "Soundblock",
                "email" => "soundblock@support.arena.com"
            ],
        ],
        "develop" => [
            "app" => [
                "url" => "https://develop.soundblock.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-soundblock-develop",
                    "url" => "https://arena-soundblock-develop.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E1MLPYM6RWBO7T",
                    "domain" => "https://d1s7tg4vaznl2m.cloudfront.net/",
                    "url" => "https://cloud.develop.soundblock.arena.com/"
                ],
                "eb" => [
                    "id" => "E-CRPHQGFPF3",
                    "name" => "Arena.Soundblock.Develop",
                    "environment" => "Arena-Soundblock-Develop",
                    "url" => "https://arena-soundblock-develop.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "staging" => [
            "app" => [
                "url" => "https://staging.soundblock.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-soundblock-staging",
                    "url" => "https://arena-soundblock-staging.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E3V86RO90LGZMK",
                    "domain" => "https://d3bcub3hn522ul.cloudfront.net/",
                    "url" => "https://cloud.staging.soundblock.arena.com/"
                ],
                "eb" => [
                    "id" => "E-PS5VMHRJ2V",
                    "name" => "Arena.Soundblock.Staging",
                    "environment" => "Arena-Soundblock-Staging",
                    "url" => "https://arena-soundblock-staging.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ],
        "web" => [
            "app" => [
                "url" => "https://soundblock.arena.com/"
            ],
            "aws" => [
                "bucket" => [
                    "name" => "arena-soundblock",
                    "url" => "https://arena-soundblock.s3.amazonaws.com/"
                ],
                "cloud" => [
                    "id" => "E19W88YVXWND1T",
                    "domain" => "https://d3cqaxyb4sugij.cloudfront.net/",
                    "url" => "https://cloud.soundblock.arena.com/"
                ],
                "eb" => [
                    "id" => "E-VI3VKMX8II",
                    "name" => "Arena.Soundblock",
                    "environment" => "Arena-Soundblock",
                    "url" => "https://arena-soundblock.us-east-1.elasticbeanstalk.com/"
                ]
            ]
        ]
    ]
];

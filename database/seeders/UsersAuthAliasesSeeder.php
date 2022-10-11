<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;
use App\Models\Users\Auth\UserAuthAlias;
use App\Models\BaseModel;
use Illuminate\Database\Seeder;

class UsersAuthAliasesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $aliases = [
            [//1
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(1)->user_id,
                "user_uuid"    => User::find(1)->user_uuid,
                "user_alias"   => "arescode",
                "flag_primary" => false,
            ],
            [//1
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(1)->user_id,
                "user_uuid"    => User::find(1)->user_uuid,
                "user_alias"   => "enetwizard",
                "flag_primary" => false,
            ],
            [//1
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(1)->user_id,
                "user_uuid"    => User::find(1)->user_uuid,
                "user_alias"   => "rswfire",
                "flag_primary" => false,
            ],
            [//1
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(1)->user_id,
                "user_uuid"    => User::find(1)->user_uuid,
                "user_alias"   => "samuel",
                "flag_primary" => false,
            ],
            [//1
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(1)->user_id,
                "user_uuid"    => User::find(1)->user_uuid,
                "user_alias"   => "swhite",
                "flag_primary" => true,
            ],
            [//2
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(2)->user_id,
                "user_uuid"    => User::find(2)->user_uuid,
                "user_alias"   => "damon",
                "flag_primary" => false,
            ],
            [//2
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(2)->user_id,
                "user_uuid"    => User::find(2)->user_uuid,
                "user_alias"   => "devans",
                "flag_primary" => true,
            ],
            [//3
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(3)->user_id,
                "user_uuid"    => User::find(3)->user_uuid,
                "user_alias"   => "mykola",
                "flag_primary" => false,
            ],
            [//3
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(3)->user_id,
                "user_uuid"    => User::find(3)->user_uuid,
                "user_alias"   => "mmelnyk",
                "flag_primary" => true,
            ],
            [//4
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(4)->user_id,
                "user_uuid"    => User::find(4)->user_uuid,
                "user_alias"   => "adamj",
                "flag_primary" => false,
            ],
            [//4
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(4)->user_id,
                "user_uuid"    => User::find(4)->user_uuid,
                "user_alias"   => "johnson",
                "flag_primary" => false,
            ],
            [//4
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(4)->user_id,
                "user_uuid"    => User::find(4)->user_uuid,
                "user_alias"   => "jadam",
                "flag_primary" => true,
            ],
            [ //5
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(5)->user_id,
                "user_uuid"    => User::find(5)->user_uuid,
                "user_alias"   => "mmunir",
                "flag_primary" => false,
            ],
            [//5
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(5)->user_id,
                "user_uuid"    => User::find(5)->user_uuid,
                "user_alias"   => "mohsin",
                "flag_primary" => true,
            ],
            [ //6
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(6)->user_id,
                "user_uuid"    => User::find(6)->user_uuid,
                "user_alias"   => "shari",
                "flag_primary" => false,
            ],
            [//6
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(6)->user_id,
                "user_uuid"    => User::find(6)->user_uuid,
                "user_alias"   => "scallahan",
                "flag_primary" => true,
            ],
            [ //7
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(7)->user_id,
                "user_uuid"    => User::find(7)->user_uuid,
                "user_alias"   => "geoff",
                "flag_primary" => false,
            ],
            [ //7
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(7)->user_id,
                "user_uuid"    => User::find(7)->user_uuid,
                "user_alias"   => "gloo",
                "flag_primary" => true,
            ],
            [//8
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(8)->user_id,
                "user_uuid"    => User::find(8)->user_uuid,
                "user_alias"   => "brian",
                "flag_primary" => false,
            ],
            [//8
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(8)->user_id,
                "user_uuid"    => User::find(8)->user_uuid,
                "user_alias"   => "bzeman",
                "flag_primary" => true,
            ],
            [//9
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(9)->user_id,
                "user_uuid"    => User::find(9)->user_uuid,
                "user_alias"   => "sanderson",
                "flag_primary" => true,
            ],
            [//9
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(9)->user_id,
                "user_uuid"    => User::find(9)->user_uuid,
                "user_alias"   => "seth",
                "flag_primary" => false,
            ],
            [//9
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(9)->user_id,
                "user_uuid"    => User::find(9)->user_uuid,
                "user_alias"   => "sethanderson",
                "flag_primary" => false,
            ],
            [//9
                "alias_uuid"   => Util::uuid(),
                "user_id"      => User::find(9)->user_id,
                "user_uuid"    => User::find(9)->user_uuid,
                "user_alias"   => "sethdanderson",
                "flag_primary" => false,
            ],
        ];

        foreach ($aliases as $alias) {
            UserAuthAlias::create($alias);
        }

        Model::reguard();
    }
}

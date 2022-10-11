<?php

namespace Database\Seeders;

use Util;
use Illuminate\Database\Seeder;
use App\Models\Soundblock\Data\PlansType as PlansTypeModel;

class SoundblockDataPlansTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrPlansTypes = [
            "Simple" => [
                "plan_name"                 => "Simple Distribution",
                "plan_rate"                 => 0,
                "plan_diskspace"            => 0,
                "plan_bandwidth"            => 0,
                "plan_additional_bandwidth" => 0,
                "plan_users"                => 0,
                "plan_additional_user"      => 0,
                "plan_level"                => 1,
                "plan_version"              => 1
            ],
            "Reporting"     => [
                "plan_name"                 => "Blockchain Reporting",
                "plan_rate"                 => 24.99,
                "plan_diskspace"            => 250,
                "plan_bandwidth"            => 25,
                "plan_additional_bandwidth" => 0.10,
                "plan_users"                => 1,
                "plan_additional_user"      => 1.99,
                "plan_level"                => 2,
                "plan_version"              => 1
            ],
            "Collaboration" => [
                "plan_name"                 => "Blockchain Collaboration",
                "plan_rate"                 => 249.99,
                "plan_diskspace"            => 1000,
                "plan_bandwidth"            => 200,
                "plan_additional_bandwidth" => 0.9,
                "plan_users"                => 4,
                "plan_additional_user"      => 1.99,
                "plan_level"                => 3,
                "plan_version"              => 1
            ],
            "Enterprise"    => [
                "plan_name"                 => "Blockchain Enterprise",
                "plan_rate"                 => 599.99,
                "plan_diskspace"            => 0,
                "plan_bandwidth"            => 500,
                "plan_additional_bandwidth" => 0.8,
                "plan_users"                => 6,
                "plan_additional_user"      => 1.99,
                "plan_level"                => 4,
                "plan_version"              => 1
            ]
        ];

        foreach ($arrPlansTypes as $arrPlanType) {
            $arrPlanType["data_uuid"] = Util::uuid();
            PlansTypeModel::create($arrPlanType);
        }
    }
}

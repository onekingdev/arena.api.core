<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Soundblock\Accounts\AccountPlan;

class SoundblockServicePlanSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $planType = ["Simple Distribution", "Blockchain Reporting", "Blockchain Collaboration", "Blockchain Enterprise"];
        $lederId = 0;
        $faker = Factory::create();
        $planCost = config("constant.soundblock.account_plan_cost");

        foreach (Account::all() as $objAccount) {
            $lederId++;

            AccountPlan::create([
                "plan_uuid"    => Util::uuid(),
                "account_id"   => $objAccount->account_id,
                "account_uuid" => $objAccount->account_uuid,
                "ledger_id"    => $lederId,
                "ledger_uuid"  => Util::uuid(),
                "plan_cost"    => $planCost[rand(0, count($planCost) - 1)],
                "service_date" => $faker->date,
                "plan_type"    => $planType[rand(0, 1)],
                "flag_active"  => 1,
            ]);
        }

        Model::reguard();
    }
}

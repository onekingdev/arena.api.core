<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\BaseModel;
use Illuminate\Database\Seeder;
use App\Models\Core\Auth\AuthGroup;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Projects\Contracts\Contract;

class SoundblockContractSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        foreach (Project::all() as $objProject) {
            Contract::create([
                "contract_uuid" => Util::uuid(),
                "account_id"    => $objProject->account->account_id,
                "account_uuid"  => $objProject->account->account_uuid,
                "project_id"    => $objProject->project_id,
                "project_uuid"  => $objProject->project_uuid,
                "stamp_begins"  => time(),
            ]);
        }

        $arrPayout = [20, 20, 20, 10, 10, 10, 10, 10, 10];

        foreach (Contract::all() as $objContract) {
            $objProject = $objContract->project;
            $objGroup = AuthGroup::where("group_name", "App.Soundblock.Project.$objProject->project_uuid")
                                 ->firstOrFail();
            $count = $objGroup->users->count();

            foreach ($objGroup->users as $key => $objUser) {
                $objUser->contracts()->attach($objContract->contract_id, [
                    "row_uuid"                  => Util::uuid(),
                    "contract_uuid"             => $objContract->contract_uuid,
                    "contract_status"           => "Pending",
                    "user_uuid"                 => $objUser->user_uuid,
                    "user_payout"               => $arrPayout[$key],
                    BaseModel::CREATED_AT       => Util::now(),
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => 1,
                    BaseModel::UPDATED_AT       => Util::now(),
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => 1,
                ]);
            }
        }

        Model::reguard();
    }
}

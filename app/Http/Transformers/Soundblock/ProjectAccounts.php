<?php

namespace App\Http\Transformers\Soundblock;

use Auth;
use League\Fractal\TransformerAbstract;
use App\Models\Soundblock\Accounts\Account as AccountModel;
use App\Repositories\Soundblock\Project as ProjectRepository;

class ProjectAccounts extends TransformerAbstract
{
    public function transform(AccountModel $objAccount)
    {
        $projectRepo = resolve(ProjectRepository::class);

        $response = [
            "account_name" => $objAccount->account_name,
            "account_uuid" => $objAccount->account_uuid,
            "stamp_created" => $objAccount->stamp_created,
            "stamp_created_by" => $objAccount->stamp_created_by,
            "stamp_updated" => $objAccount->stamp_updated,
            "stamp_updated_by" => $objAccount->stamp_updated_by,
            "user" => [
                "user_uuid" => $objAccount->user->user_uuid,
                "user_name" => $objAccount->user->name,
                "avatar" => $objAccount->user->avatar
            ],
            "projects" => $objAccount->projects
        ];

        foreach ($response["projects"] as $key => $project) {
            if (!empty($project)) {
                $res = $projectRepo->checkUserPartOfContract($objAccount->projects[$key], Auth::user()->user_uuid);
                if ($res && $res->pivot->contract_status == "Accepted") {
                    $response["projects"][$key]["flag_contract"] = true;
                } else {
                    $response["projects"][$key]["flag_contract"] = false;
                }
            }
        }

        return(array_merge($response));
    }
}

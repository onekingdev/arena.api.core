<?php

namespace App\Services\Soundblock;

use App\Models\Soundblock\Projects\Project;
use App\Repositories\Soundblock\Contract as ContractRepository;

class Contract {
    /** @var ContractRepository */
    protected ContractRepository $contractRepo;


    /**
     * Contract constructor.
     * @param ContractRepository $contractRepo
     */
    public function __construct(ContractRepository $contractRepo) {
        $this->contractRepo = $contractRepo;
    }

    /**
     * @param Project $objProject
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(Project $objProject) {
        $arrContract = [];

        $arrContract["project_id"]   = $objProject->project_id;
        $arrContract["project_uuid"] = $objProject->project_uuid;
        $arrContract["account_id"]   = $objProject->account->account_id;
        $arrContract["account_uuid"] = $objProject->account->account_uuid;

        return ($this->contractRepo->create($arrContract));
    }
}

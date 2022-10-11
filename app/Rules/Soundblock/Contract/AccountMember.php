<?php

namespace App\Rules\Soundblock\Contract;

use App\Models\BaseModel;
use App\Models\Soundblock\Accounts\Account;
use App\Repositories\Soundblock\Project;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class AccountMember implements Rule {
    /**
     * @var Request
     */
    private Request $objRequest;

    /**
     * Create a new rule instance.
     *
     * @param Request $objRequest
     */
    public function __construct(Request $objRequest) {
        $this->objRequest = $objRequest;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $strProjectUuid = $this->objRequest->route("project");
        /** @var Project $objProjectRepository */
        $objProjectRepository = resolve(Project::class);
        $objProject = $objProjectRepository->find($strProjectUuid, true);
        /** @var Account $objAccount */
        $objAccount = $objProject->account;

        return $objAccount->users()->where("users.user_uuid", $value)->wherePivotNull(BaseModel::DELETED_AT)
            ->exists() || $objAccount->user_uuid === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return "User Must Accept Invite Before Adding To Contract.";
    }
}

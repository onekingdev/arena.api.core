<?php

namespace App\Rules\Soundblock\Contract;

use App\Repositories\Soundblock\Project;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class Members implements Rule {
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
        $objAccount = $objProject->account;

        return collect($value)->where("uuid", $objAccount->user_uuid)->isNotEmpty();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return "One Of Contract Members Must Be A Project Owner.";
    }
}

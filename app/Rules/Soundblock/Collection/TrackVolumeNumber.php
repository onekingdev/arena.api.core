<?php

namespace App\Rules\Soundblock\Collection;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\Soundblock\Project;

class TrackVolumeNumber implements Rule
{
    private array $requestData;

    /**
     * Create a new rule instance.
     *
     * @param array $arrAllData
     */
    public function __construct(array $arrAllData)
    {
        $this->requestData = $arrAllData;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $objProjectRepo = resolve(Project::class);
        $objProject = $objProjectRepo->find($this->requestData["project"]);

        if ($objProject->project_volumes < intval($value)) {
            return (false);
        }

        return (true);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Track volume number can't be greater than project total volumes.";
    }
}

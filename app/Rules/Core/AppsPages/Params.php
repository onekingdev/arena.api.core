<?php

namespace App\Rules\Core\AppsPages;

use Illuminate\Contracts\Validation\Rule;
use App\Contracts\Core\PageStructure as PageStructureContract;

class Params implements Rule
{
    /**
     * @var string
     */
    private string $struct;

    private PageStructureContract $pageStruct;

    /**
     * Create a new rule instance.
     *
     * @param string $structUuid
     */
    public function __construct(string $structUuid)
    {
        $this->struct = $structUuid;
        $this->pageStruct = resolve(PageStructureContract::class);
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
        foreach ($value as $param => $array) {
            foreach ($array as $val) {
                $boolResult = $this->pageStruct->validateParams($this->struct, $param, $val);
                if (!$boolResult) {
                    return (false);
                }
            }
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
        return 'Given param is invalid.';
    }
}

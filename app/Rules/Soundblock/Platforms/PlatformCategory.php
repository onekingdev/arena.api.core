<?php

namespace App\Rules\Soundblock\Platforms;

use Illuminate\Contracts\Validation\Rule;

class PlatformCategory implements Rule {

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $isEmpty =  empty(array_filter(config("constant.soundblock.platform_category"), function ($category) use ($value) {
            return strtolower($category) == strtolower($value);
        }));

        return $isEmpty === false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return 'The value must be valid platform category.';
    }
}

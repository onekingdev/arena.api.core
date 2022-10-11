<?php

namespace App\Rules\Office\Music;

use Illuminate\Contracts\Validation\Rule;

class FlagHide implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach (config("constant.music.project.flag_office_hide") as $flag) {
            if (strtolower($value) == $flag) {
                return (true);
            }
        }

        return (false);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Invalid flag office hide name.";
    }
}

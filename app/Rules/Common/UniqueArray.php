<?php

namespace App\Rules\Common;

use Illuminate\Contracts\Validation\Rule;

class UniqueArray implements Rule {
    private array $array;
    private string $field;

    /**
     * Create a new rule instance.
     *
     * @param array $array
     * @param string $field
     */
    public function __construct(array $array, string $field) {
        $this->array = $array;
        $this->field = $field;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) {
        return collect($this->array)->duplicates($this->field)->isEmpty();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return 'This Field Must Be Unique.';
    }
}

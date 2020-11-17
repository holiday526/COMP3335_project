<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckVariantRule implements Rule
{
    private $variant;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        //
        $this->variant = $value;
        return in_array($value, ['primary', 'secondary', 'success', 'warning', 'danger', 'info', 'light', 'dark']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "$this->variant passed in variant is invalid";
    }
}

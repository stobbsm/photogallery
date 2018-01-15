<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\File;

class Checksum implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * 
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return File::where('checksum', $value)->isEmpty();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This file already exists.';
    }
}

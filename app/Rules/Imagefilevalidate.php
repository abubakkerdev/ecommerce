<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Imagefilevalidate implements Rule
{
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
        $key = '';
        $num = 1;

        foreach ($value as $sizeNumber)
        {
            $number = $sizeNumber->getSize();

            if ($number < 500000)
            {
                $key .= $num.',';
            }
            $num++;
        }

        $explode = explode(',', $key);

        if ((count($explode)-1) == count($value))
        {
            return $key;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The product preview must not be greater than 500 kilobytes.';
    }
}

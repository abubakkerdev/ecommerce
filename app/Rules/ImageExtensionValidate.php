<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageExtensionValidate implements Rule
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
        $allowed_extension  = array("jpeg", "png", "gif", "svg", "jpg", "webp");
        $key = '';

        foreach ($value as $img_extension)
        {
            $extension = $img_extension->getClientOriginalExtension();

            if (in_array($extension, $allowed_extension))
            {
                $key .= $extension.',';
            }
        }

        $explode = explode(',', $key);

        if ((count($explode)-1) == count($value))
        {
            return $extension;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The product thumbnail must be an image.';
    }
}

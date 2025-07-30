<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TimeFormat implements Rule
{
    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return true;
        }

        return preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/', $value);
    }

    public function message()
    {
        return 'تنسيق الوقت غير صحيح. استخدم الصيغة HH:MM (مثال: 09:00 أو 14:30)';
    }
}

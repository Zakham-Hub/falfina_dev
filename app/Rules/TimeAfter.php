<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TimeAfter implements Rule
{
    protected $otherField;
    protected $otherFieldName;

    public function __construct($otherField, $otherFieldName = null)
    {
        $this->otherField = $otherField;
        $this->otherFieldName = $otherFieldName ?: $otherField;
    }

    public function passes($attribute, $value)
    {
        if (empty($value) || empty(request($this->otherField))) {
            return true;
        }

        $valueTime = strtotime($value);
        $otherTime = strtotime(request($this->otherField));

        // If either time is invalid, skip validation
        if ($valueTime === false || $otherTime === false) {
            return true;
        }

        return $valueTime > $otherTime;
    }

    public function message()
    {
        return "يجب أن يكون الوقت بعد {$this->otherFieldName}";
    }
}

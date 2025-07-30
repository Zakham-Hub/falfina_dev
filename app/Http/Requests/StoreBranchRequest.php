<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\TimeFormat;
use App\Rules\TimeAfter;

class StoreBranchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'coordinate' => 'nullable|string',

            'daily_schedules' => 'required|array',
            'daily_schedules.*.is_holiday' => 'sometimes|boolean',
            'daily_schedules.*.shifts' => 'required_if:daily_schedules.*.is_holiday,false|array|min:1',
            'daily_schedules.*.shifts.*.name' => 'nullable|string|max:255',
            'daily_schedules.*.shifts.*.delivery_start_time' => 'required|date_format:H:i',
            'daily_schedules.*.shifts.*.delivery_end_time' => [
                'required',
                'date_format:H:i',
                new TimeAfter('daily_schedules.*.shifts.*.delivery_start_time', 'وقت بداية التوصيل')
            ],
            'daily_schedules.*.shifts.*.pickup_start_time' => 'required|date_format:H:i',
            'daily_schedules.*.shifts.*.pickup_end_time' => [
                'required',
                'date_format:H:i',
                new TimeAfter('daily_schedules.*.shifts.*.pickup_start_time', 'وقت بداية الاستلام')
            ],

            'exceptional_holidays' => 'sometimes|array',
            'exceptional_holidays.*.title' => 'required_if:exceptional_holidays,array|string|max:255',
            'exceptional_holidays.*.start_date' => 'required_if:exceptional_holidays,array|date_format:Y-m-d',
            'exceptional_holidays.*.end_date' => 'nullable|date_format:Y-m-d|after_or_equal:exceptional_holidays.*.start_date',
            'exceptional_holidays.*.is_recurring' => 'sometimes|boolean',
            'exceptional_holidays.*.description' => 'nullable|string',

            'special_occasions' => 'sometimes|array',
            'special_occasions.*.occasion_name' => 'required_if:special_occasions,array|string|max:255',
            'special_occasions.*.date' => 'required_if:special_occasions,array|date_format:Y-m-d',
            'special_occasions.*.is_holiday' => 'sometimes|boolean',
            'special_occasions.*.opening_time' => [
                'required_if:special_occasions.*.is_holiday,false',
                'nullable',
                'date_format:H:i'
            ],
            'special_occasions.*.closing_time' => [
                'required_if:special_occasions.*.is_holiday,false',
                'nullable',
                'date_format:H:i',
                new TimeAfter('special_occasions.*.opening_time', 'وقت الفتح')
            ],
            'special_occasions.*.delivery_start_time' => [
                'required_if:special_occasions.*.is_holiday,false',
                'nullable',
                'date_format:H:i'
            ],
            'special_occasions.*.delivery_end_time' => [
                'required_if:special_occasions.*.is_holiday,false',
                'nullable',
                'date_format:H:i',
                new TimeAfter('special_occasions.*.delivery_start_time', 'وقت بداية التوصيل')
            ],
            'special_occasions.*.pickup_start_time' => [
                'required_if:special_occasions.*.is_holiday,false',
                'nullable',
                'date_format:H:i'
            ],
            'special_occasions.*.pickup_end_time' => [
                'required_if:special_occasions.*.is_holiday,false',
                'nullable',
                'date_format:H:i',
                new TimeAfter('special_occasions.*.pickup_start_time', 'وقت بداية الاستلام')
            ],
            'special_occasions.*.description' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'اسم الفرع',
            'latitude' => 'خط العرض',
            'longitude' => 'خط الطول',
            'address' => 'العنوان',
            'phone' => 'الهاتف',
            'coordinate' => 'الإحداثيات',

            'daily_schedules.*.is_holiday' => 'حالة الإجازة',
            'daily_schedules.*.opening_time' => 'وقت الفتح',
            'daily_schedules.*.closing_time' => 'وقت الإغلاق',
            'daily_schedules.*.delivery_start_time' => 'وقت بداية التوصيل',
            'daily_schedules.*.delivery_end_time' => 'وقت نهاية التوصيل',
            'daily_schedules.*.pickup_start_time' => 'وقت بداية الاستلام',

            'exceptional_holidays.*.title' => 'عنوان الإجازة',
            'exceptional_holidays.*.start_date' => 'تاريخ البدء',
            'exceptional_holidays.*.end_date' => 'تاريخ الانتهاء',
            'exceptional_holidays.*.is_recurring' => 'التكرار السنوي',
            'exceptional_holidays.*.description' => 'وصف الإجازة',

            'special_occasions.*.occasion_name' => 'اسم المناسبة',
            'special_occasions.*.date' => 'تاريخ المناسبة',
            'special_occasions.*.is_holiday' => 'حالة الإجازة',
            'special_occasions.*.opening_time' => 'وقت الفتح',
            'special_occasions.*.closing_time' => 'وقت الإغلاق',
            'special_occasions.*.delivery_start_time' => 'وقت بداية التوصيل',
            'special_occasions.*.delivery_end_time' => 'وقت نهاية التوصيل',
            'special_occasions.*.description' => 'وصف المناسبة'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'حقل :attribute مطلوب.',
            'string' => 'حقل :attribute يجب أن يكون نصاً.',
            'max' => 'حقل :attribute يجب أن لا يتجاوز :max حرف.',
            'numeric' => 'حقل :attribute يجب أن يكون رقماً.',
            'date_format' => 'حقل :attribute يجب أن يكون بتنسيق :format.',
            'after_or_equal' => 'حقل :attribute يجب أن يكون تاريخاً لاحقاً أو مساوياً لـ :date.',
            'boolean' => 'حقل :attribute يجب أن يكون حالة صحيحة أو خاطئة.',

            'daily_schedules.required' => 'مواعيد العمل اليومية مطلوبة.',
            'daily_schedules.*.opening_time.required_if' => 'وقت الفتح مطلوب عندما لا يكون اليوم إجازة.',
            'daily_schedules.*.closing_time.required_if' => 'وقت الإغلاق مطلوب عندما لا يكون اليوم إجازة.',
            'daily_schedules.*.delivery_start_time.required_if' => 'وقت بداية التوصيل مطلوب عندما لا يكون اليوم إجازة.',
            'daily_schedules.*.delivery_end_time.required_if' => 'وقت نهاية التوصيل مطلوب عندما لا يكون اليوم إجازة.',
            'daily_schedules.*.pickup_start_time.required_if' => 'وقت بداية الاستلام مطلوب عندما لا يكون اليوم إجازة.',

            'exceptional_holidays.*.title.required_if' => 'عنوان الإجازة مطلوب.',
            'exceptional_holidays.*.start_date.required_if' => 'تاريخ بداية الإجازة مطلوب.',

            'special_occasions.*.occasion_name.required_if' => 'اسم المناسبة مطلوب.',
            'special_occasions.*.date.required_if' => 'تاريخ المناسبة مطلوب.',
            'special_occasions.*.opening_time.required_if' => 'وقت الفتح مطلوب عندما لا تكون المناسبة إجازة.',
            'special_occasions.*.closing_time.required_if' => 'وقت الإغلاق مطلوب عندما لا تكون المناسبة إجازة.',
            'special_occasions.*.delivery_start_time.required_if' => 'وقت بداية التوصيل مطلوب عندما لا تكون المناسبة إجازة.',
            'special_occasions.*.delivery_end_time.required_if' => 'وقت نهاية التوصيل مطلوب عندما لا تكون المناسبة إجازة.'
        ];
    }
}

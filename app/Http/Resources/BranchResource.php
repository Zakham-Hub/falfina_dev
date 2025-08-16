<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "type" => $this->type,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "phone" => $this->phone,
            "address" => $this->address,
            "coordinate" => $this->coordinate,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "daily_schedules" => $this->dailySchedules->map(function (
                $schedule,
            ) {
                return [
                    "id" => $schedule->id,
                    "day" => $schedule->day,
                    "is_holiday" => $schedule->is_holiday,
                    "shifts" => $schedule->shifts->map(function ($shift) {
                        return [
                            "id" => $shift->id,
                            "name" => $shift->name,
                            "delivery_start_time" =>
                                $shift->delivery_start_time,
                            "delivery_end_time" => $shift->delivery_end_time,
                            "pickup_start_time" => $shift->pickup_start_time,
                            "pickup_end_time" => $shift->pickup_end_time,
                        ];
                    }),
                ];
            }),
            "exceptional_holidays" => $this->exceptionalHolidays->map(function (
                $holiday,
            ) {
                return [
                    "id" => $holiday->id,
                    "title" => $holiday->title,
                    "start_date" => $holiday->start_date,
                    "end_date" => $holiday->end_date,
                    "description" => $holiday->description,
                    "is_recurring" => $holiday->is_recurring,
                ];
            }),
            "special_occasions" => $this->specialOccasions->map(function (
                $occasion,
            ) {
                return [
                    "id" => $occasion->id,
                    "occasion_name" => $occasion->occasion_name,
                    "date" => $occasion->date,
                    "is_holiday" => $occasion->is_holiday,
                    "opening_time" => $occasion->opening_time,
                    "closing_time" => $occasion->closing_time,
                    "delivery_start_time" => $occasion->delivery_start_time,
                    "delivery_end_time" => $occasion->delivery_end_time,
                    "pickup_start_time" => $occasion->pickup_start_time,
                    "pickup_end_time" => $occasion->pickup_end_time,
                    "description" => $occasion->description,
                ];
            }),
        ];
    }
}

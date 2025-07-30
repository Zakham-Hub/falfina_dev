<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchShift extends Model
{
    use HasFactory;
    protected $fillable = [
        'daily_schedule_id',
        'name',
        'delivery_start_time',
        'delivery_end_time',
        'pickup_start_time',
        'pickup_end_time'
    ];

    public function dailySchedule()
    {
        return $this->belongsTo(BranchDailySchedule::class);
    }
}

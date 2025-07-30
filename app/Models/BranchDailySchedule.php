<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchDailySchedule extends Model
{
    protected $fillable = ['branch_id', 'day', 'is_holiday'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function shifts()
    {
        return $this->hasMany(BranchShift::class, 'daily_schedule_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchSpecialOccasion extends Model
{
    use HasFactory;
    protected $fillable = [
        'branch_id',
        'occasion_name',
        'date',
        'is_holiday',
        'opening_time',
        'closing_time',
        'delivery_start_time',
        'delivery_end_time',
        'pickup_start_time',
        'pickup_end_time',
        'description'
    ];

    protected $casts = [
        'date' => 'date',
        'is_holiday' => 'boolean'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}

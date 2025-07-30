<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchExceptionalHoliday extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'title',
        'start_date',
        'end_date',
        'description',
        'is_recurring'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_recurring' => 'boolean'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}

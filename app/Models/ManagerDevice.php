<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Manager;

class ManagerDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_id',
        'fcm_token',
        'device_name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the admin that owns the device.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class,'manager_id');
    }
} 
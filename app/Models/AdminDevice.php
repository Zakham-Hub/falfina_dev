<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Admin;


class AdminDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
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
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
} 
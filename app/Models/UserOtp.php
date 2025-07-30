<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'otp_code',
        'expires_at',
        'verified_at',
        'attempts',
        'is_verified'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_verified' => 'boolean'
    ];

    /**
     * Relationship with User model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if OTP is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at < Carbon::now();
    }

    /**
     * Check if OTP is valid
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->is_verified && $this->attempts < 3;
    }

    /**
     * Mark OTP as verified
     */
    public function markAsVerified(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => Carbon::now()
        ]);
    }

    /**
     * Increment attempts
     */
    public function incrementAttempts(): void
    {
        $this->increment('attempts');
    }

    /**
     * Generate new OTP code
     */
    public static function generateOtpCode(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', \STR_PAD_LEFT);
    }

    /**
     * Scope for active OTPs
     */
    public function scopeActive($query)
    {
        return $query->where('is_verified', false)
                    ->where('expires_at', '>', Carbon::now())
                    ->where('attempts', '<', 3);
    }
}

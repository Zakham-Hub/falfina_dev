<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Concerns\History\Historyable;
class Admin extends Authenticatable implements JWTSubject {
    use HasFactory, Notifiable, Historyable;
    protected $table = 'admins';
    protected $fillable = ['name', 'email', 'password', 'phone', 'status', 'type','link_password_status','link_password_protection'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'string',
        'type' => 'string',
    ];

    public function setPasswordAttribute($value) {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function profile(): HasOne {
        return $this->hasOne(related: AdminProfile::class, foreignKey: 'admin_id');
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
}

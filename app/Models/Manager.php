<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Manager extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'managers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'branch_id',
        'status',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UploadMedia;

class Setting extends Model
{
    use HasFactory, UploadMedia;
    protected $table = 'settings';
    protected $fillable = [
        'name',
        'email',
        'description',
        'phone',
        'address',
        'status',
        'currency',
        'loyalty_points',
        'delivery_fees',
        'version'
    ];

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}

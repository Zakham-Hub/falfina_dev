<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UploadMedia;
use App\Models\Concerns\History\Historyable;
class Setting extends Model
{
    use HasFactory, UploadMedia,Historyable;
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
        'delivery_fee_per_km',
        'delivery_range',
        'version'
    ];

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}

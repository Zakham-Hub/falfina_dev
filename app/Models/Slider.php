<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UploadMedia;
use App\Models\Concerns\History\Historyable;
class Slider extends Model
{
    use HasFactory, UploadMedia,Historyable;
    protected $table = 'sliders';
    protected $fillable = [
        'name',
        'description',
    ];

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}

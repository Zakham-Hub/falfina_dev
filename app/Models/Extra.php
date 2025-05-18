<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UploadMedia;
use App\Models\Concerns\History\Historyable;
class Extra extends Model
{
    use HasFactory, UploadMedia,Historyable;
    protected $table = "extras";
    protected $fillable = ['name', 'price', 'type'];
    public function scopeSauces($query)
    {
        return $query->whereType('sauce');
    }

    public function scopeAddons($query)
    {
        return $query->whereType('addon');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_extra');
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\UploadMedia;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory, UploadMedia;
    protected $table = 'packages';
    protected $guarded = [];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_package', 'package_id', 'product_id');
    }
    public function media() {
        return $this->morphMany(Media::class, 'mediable');
    }
}

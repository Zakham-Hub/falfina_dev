<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UploadMedia;
class Product extends Model {
    use HasFactory, UploadMedia;
    protected $fillable = ['name', 'alt_name', 'description', 'short_description','price', 'loyalty_points'];

    public function categories() {
        return $this->belongsToMany(Category::class, 'category_products');
    }
    public function sizes() {
        return $this->belongsToMany(Size::class, 'product_size')->withPivot('price');
    }

    public function types() {
        return $this->belongsToMany(Type::class, 'product_type');
    }

    public function extras() {
        return $this->belongsToMany(Extra::class, 'product_extra');
    }
    public function media() {
        return $this->morphMany(Media::class, 'mediable');
    }
}

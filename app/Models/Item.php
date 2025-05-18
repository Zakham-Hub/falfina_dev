<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UploadMedia;
class Item extends Model
{
    use HasFactory, UploadMedia;

    protected $fillable = [
        'name',
        'item_type_id',
    ];

    /**
     * Define the relationship with ItemType.
     */
    public function itemType()
    {
        return $this->belongsTo(ItemType::class, 'item_type_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_item'); // Explicitly specify the table name
    }

    /**
     * Register media collections.
     */
    public function media() {
        return $this->morphMany(Media::class, 'mediable');
    }
}

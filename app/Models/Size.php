<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
class Size extends Model
{
    use HasFactory,Historyable;

    protected $fillable = [
        'name',
        'gram',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_size')->withPivot('price');
    }
}

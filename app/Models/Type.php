<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
class Type extends Model {
    use HasFactory,Historyable;
    protected $table = 'types';
    protected $fillable = ['name'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_type');
    }
    public function scopeActive($query){
        return $query->where('status','active');
    }
}

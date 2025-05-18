<?php

namespace App\Models;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model {
    use HasFactory;
    protected $table = "branches";
    protected $fillable = ['name', 'latitude', 'longitude', 'address', 'phone'];

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }
    public function scopeActive($query){
        return $query->where('status','active');
    }
}

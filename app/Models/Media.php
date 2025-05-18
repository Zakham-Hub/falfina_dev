<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = ['file_name', 'disk', 'collection_name'];
    public function mediable()
    {
        return $this->morphTo();
    }
}

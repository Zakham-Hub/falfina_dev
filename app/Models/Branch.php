<?php

namespace App\Models;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\History\Historyable;
class Branch extends Model {
    use HasFactory, Historyable;
    protected $table = "branches";
    protected $fillable = ['name', 'latitude', 'longitude', 'address', 'phone', 'coordinate'];

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }
    public function scopeActive($query){
        return $query->where('status','active');
    }

     public function dailySchedules()
    {
        return $this->hasMany(BranchDailySchedule::class);
    }

    public function exceptionalHolidays()
    {
        return $this->hasMany(BranchExceptionalHoliday::class);
    }

    public function specialOccasions()
    {
        return $this->hasMany(BranchSpecialOccasion::class);
    }
}

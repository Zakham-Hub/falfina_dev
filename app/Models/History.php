<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'histories';
    protected $fillable = [
        'historyable_id',
        'historyable_type',
        'changed_column',
        'change_value_from',
        'change_value_to',
        'admin_id',
        'user_id',
        'manager_id'
    ];
    protected $appends = ['model_name', 'related_name', 'related_info'];
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function historyable()
    {
        return $this->morphTo();
    }

    public function getModelNameAttribute() {
        $model = class_basename($this->historyable_type);
        return __('dashboard/models.' . $model);
    }

    public function getRelatedNameAttribute() {
        $model = $this->historyable;
        if (!$model) {
            return null;
        }
        if ($model instanceof \App\Models\Order) {
            return $model->name . ' - ' . $model->order_number;
        }
        return $model->name ?? null;
    }

    public function getRelatedInfoAttribute() {
        $model = $this->historyable;
        if (!$model) {
            return null;
        }
        if ($model instanceof \App\Models\Order) {
            return [
                'name' => $model->name,
                'order_number' => $model->order_number,
            ];
        }
        return [
            'name' => $model->name ?? null,
        ];
    }
}

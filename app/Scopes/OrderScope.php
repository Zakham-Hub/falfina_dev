<?php
namespace App\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
class OrderScope implements Scope {
    public function apply(Builder $builder, Model $model) {
        $authUser = check_guard()?->user();
        if (!$authUser) {
            return;
        }
        if (manager_guard()->check()) {
            $builder->where('branch_id', $authUser->branch_id);
        }
        $builder->latest();
    }
}

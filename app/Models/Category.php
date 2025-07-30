<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UploadMedia;
use App\Models\Concerns\History\Historyable;
class Category extends Model {
    use HasFactory, UploadMedia, Historyable;
    protected $table = 'categories';
    protected $fillable = ['name', 'parent_id', 'status', 'description', 'short_description'];
    protected $appends = ['status_text'];
    public function media() {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive() {
        return $this->hasMany(Category::class, 'parent_id')->with('childrenRecursive');
    }

    public static function getCategoryTree($parentId = null, $status = 'active') {
        return self::byParent($parentId)
            ->active($status)
            ->select('id', 'name', 'parent_id')
            ->with(['children' => function ($query) use ($status) {
                $query->active($status)
                    ->select('id', 'name', 'parent_id');
            }])
            ->get();
    }

    public static function getCategoryOptions($parentId = null, $status = 'active', $prefix = '') {
        $categories = self::byParent($parentId)->active($status)->with('children')->get();
        $options = collect();
        foreach ($categories as $category) {
            $options->push([
                'id' => $category->id,
                'name' => $prefix . $category->name
            ]);
            if ($category->children->isNotEmpty()) {
                $subcategories = self::getCategoryOptions($category->id, $status, $prefix . '-- ');
                $options = $options->merge($subcategories);
            }
        }
        return $options->unique('id')->values();
    }


    public function scopeActive($query, $status = 'active')
    {
        return $query->whereStatus($status);
    }

    public function scopeByParent($query, $parentId = null) {
        return $query->when(!is_null($parentId), fn($q) => $q->where('parent_id', $parentId));
    }

    public static function getRootCategories($status = 'active') {
        return self::whereNull('parent_id')->active($status)->get();
    }

    public function getStatusTextAttribute() {
        return $this->status === 'active' ? 'نشط' : 'غير نشط';
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'category_product');
    }
}

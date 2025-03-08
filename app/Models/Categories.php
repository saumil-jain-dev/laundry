<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category  extends Model
{
    //
    Use SoftDeletes, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'parent',
        'status',
    ];

     /**
     * Get subcategories for a category (One-to-Many Relationship).
     */
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent', 'id')->where('status', 1);
    }

    /**
     * Get parent category (Many-to-One Relationship).
     */
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent', 'id');
    }

    /**
     * Scope to get only active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}

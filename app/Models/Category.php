<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'mag_categories';

    protected $guarded = [];

    protected $hidden = [
        'pivot'
    ];
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'mag_post_category', 'category_id', 'post_id');
    }

    public function subcategory(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

}

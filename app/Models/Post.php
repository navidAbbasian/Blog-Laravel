<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $table = 'mag_posts';

    protected $guarded = [];
    protected $hidden = [
        'pivot'
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'mag_post_tag', 'post_id', 'tag_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'mag_post_category', 'post_id', 'category_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function authors(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'author', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'mag_post_product', 'post_id','product_id');
    }
}

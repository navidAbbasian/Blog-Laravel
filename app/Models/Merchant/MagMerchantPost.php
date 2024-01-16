<?php

namespace App\Models\Merchant;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MagMerchantPost extends Model
{
    use HasFactory;

    protected $table = 'mag_merchant_posts';

    protected $guarded = [];
    protected $hidden = [
        'pivot'
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(MagMerchantTag::class, 'mag_merchant_post_tag', 'post_id', 'tag_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(MagMerchantCategory::class, 'mag_merchant_post_category', 'post_id', 'category_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(MagMerchantComment::class, 'post_id', 'id');
    }

    public function authors(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'author', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'mag_merchant_post_product', 'post_id','product_id');
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'mag_merchant_customer_favorite_post', 'post_id', 'customer_id');
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class,'mag_merchant_customer_bookmark_post', 'post_id', 'customer_id');
    }
}

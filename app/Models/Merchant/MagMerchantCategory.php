<?php

namespace App\Models\Merchant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MagMerchantCategory extends Model
{
    use HasFactory;

    protected $table = 'mag_merchant_categories';

    protected $guarded = [];
    protected $hidden = [
        'pivot'
    ];
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(MagMerchantPost::class, 'mag_merchant_post_category', 'category_id', 'post_id');
    }

    public function subcategory(): HasMany
    {
        return $this->hasMany(MagMerchantCategory::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MagMerchantCategory::class, 'parent_id');
    }
}

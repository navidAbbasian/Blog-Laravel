<?php

namespace App\Models\Merchant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MagMerchantTag extends Model
{
    use HasFactory;

    protected $table = 'mag_merchant_tag';

    protected $guarded = [];
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(MagMerchantPost::class, 'mag_merchant_posts', 'tag_id', 'post_id');
    }
}

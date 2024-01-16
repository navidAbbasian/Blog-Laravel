<?php

namespace App\Models\Merchant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MagMerchantComment extends Model
{
    use HasFactory;

    protected $table = 'mag_merchant_comments';

    protected $guarded = [];

    public function posts(): BelongsTo
    {
        return $this->belongsTo(MagMerchantPost::class, 'post_id', 'id');
    }
}

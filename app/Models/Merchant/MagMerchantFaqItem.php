<?php

namespace App\Models\Merchant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MagMerchantFaqItem extends Model
{
    use HasFactory;

    protected $table = 'mag_merchant_faq_items';

    protected $guarded = [];

    public function faqs(): BelongsTo
    {
        return $this->belongsTo(MagMerchantFaq::class);
    }
}

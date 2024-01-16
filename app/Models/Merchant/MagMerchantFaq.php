<?php

namespace App\Models\Merchant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MagMerchantFaq extends Model
{
    use HasFactory;

    protected $table = 'mag_merchant_faqs';

    protected $guarded = [];

    public function faqsItem(): HasMany
    {
        return $this->hasMany(MagMerchantFaqItem::class,'faq_id', 'id');
    }
}

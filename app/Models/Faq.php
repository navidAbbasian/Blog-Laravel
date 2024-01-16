<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'mag_faqs';

   protected $guarded = [];

    public function faqsItem(): HasMany
    {
        return $this->hasMany(FaqItem::class, 'faq_id', 'id');
    }
}

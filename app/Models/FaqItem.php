<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqItem extends Model
{
    use HasFactory;

    protected $table = 'mag_faq_items';

    protected $guarded = [];

    public function faqs(): BelongsTo
    {
        return $this->belongsTo(Faq::class);
    }
}

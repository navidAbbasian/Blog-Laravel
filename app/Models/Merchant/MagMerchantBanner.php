<?php

namespace App\Models\Merchant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagMerchantBanner extends Model
{
    use HasFactory;

    protected $table = 'mag_merchant_banners';

    protected $guarded = [];
}

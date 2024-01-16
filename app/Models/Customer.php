<?php

namespace App\Models;

use App\Models\Merchant\MagMerchantPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = [
        'name',
        'profile'
    ];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function merchantPosts()
    {
        return $this->hasMany(MagMerchantPost::class);
    }

    public function favoriteMerchantPosts()
    {
        return $this->belongsToMany(MagMerchantPost::class, 'mag_merchant_customer_favorite_post','customer_id', 'post_id');
    }

    public function bookmarkMerchantPosts()
    {
        return $this->belongsToMany(MagMerchantPost::class,'mag_merchant_customer_bookmark_post','customer_id', 'post_id');
    }

}

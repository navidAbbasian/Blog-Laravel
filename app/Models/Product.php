<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'name'
    ];
    public function posts()
    {
        return $this->belongsToMany(Post::class, "mag_post_product", 'product_id', 'post_id');
    }
}

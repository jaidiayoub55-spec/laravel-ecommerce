<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'name',
    'description',
    'price',
    'stock',
    'category_id',
    'image'
];

public function category()
{
    return $this->belongsTo(Category::class);
}
public function carts()
{
    return $this->hasMany(Cart::class);
}
public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}
public function reviews()
{
    return $this->hasMany(Review::class);
}
public function averageRating()
{
    return $this->reviews()->avg('rating');
}
}

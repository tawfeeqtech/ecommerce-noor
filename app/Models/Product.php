<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
//        'brand',
        'small_description',
        'description',
        'original_price',
        'selling_price',
        'quantity',
        'trending',
        'status',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function firstProductImage()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
//        return $this->hasMany(ProductImage::class)->orderBy('id', 'ASC')->take(1);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productColors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}

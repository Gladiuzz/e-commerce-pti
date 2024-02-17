<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = ['name_id', 'category_id', 'description', 'price', 'weight', 'stock', 'user_id', 'harvest_season', 'expired_information', 'purchase_detail'];

    public function productImage()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function name()
    {
        return $this->belongsTo(Name::class, 'name_id', 'id');
    }

    public function transactionProduct()
    {
        return $this->hasMany(transactionProduct::class, 'product_id', 'id');
    }
    protected static function booted()
    {
        static::deleting(function (Product $Product) {
            $Product->productImage()->delete();
            $Product->productCategory()->delete();
            $Product->user()->delete();
            $Product->name()->delete();
            $Product->transactionProduct()->delete();
        });
    }
}

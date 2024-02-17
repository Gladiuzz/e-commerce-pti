<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function product()
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }
    protected static function booted()
    {
        static::deleting(function (TransactionProduct $Name) {
            $Name->product()->delete();
        });
    }
}

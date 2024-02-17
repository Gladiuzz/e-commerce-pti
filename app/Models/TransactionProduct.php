<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionProduct extends Model
{
    use HasFactory;

    protected $table = 'transaction_product';

    protected $fillable = ['transaction_id', 'product_id', 'qty'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    protected static function booted()
    {
        static::deleting(function (TransactionProduct $TransactionProduct) {
            $TransactionProduct->transaction()->delete();
            $TransactionProduct->product()->delete();
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverProduct extends Model
{
    use HasFactory;
    protected $table = 'driver_product';

    protected $fillable = ['id_product', 'id_user'];

    public function transactionProduct()
    {
        return $this->belongsTo(TransactionProduct::class, 'id_product', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    
    protected static function booted()
    {
        static::deleting(function (DriverProduct $DriverProduct) {
            $DriverProduct->transactionProduct()->delete();
            $DriverProduct->user()->delete();
        });
    }
}

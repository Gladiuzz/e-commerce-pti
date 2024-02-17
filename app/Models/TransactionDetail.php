<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_detail';

    protected $fillable = ['transaction_id', 'driver_id' , 'no_receipt', 'name', 'phone_number', 'email', 'full_address', 'city', 'province', 'courier_type', 'courier_status', 'zip_code'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }

    protected static function booted()
    {
        static::deleting(function (TransactionDetail $TransactionDetail) {
            $TransactionDetail->transaction()->delete();
        });
    }
}

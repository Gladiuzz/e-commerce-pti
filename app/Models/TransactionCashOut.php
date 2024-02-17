<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCashOut extends Model
{
    use HasFactory;

    protected $table = 'transaction_cash_out';

    protected $fillable = ['user_id', 'status', 'transaction_id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    protected static function booted()
    {
        static::deleting(function (TransactionCashOut $TransactionCashOut) {
            $TransactionCashOut->transaction()->delete();
            $TransactionCashOut->user()->delete();
        });
    }
}

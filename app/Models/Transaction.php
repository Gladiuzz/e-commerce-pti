<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';

    protected $fillable = ['user_id', 'trx_id', 'session_id', 'url', 'transaction_date', 'amount', 'method', 'status','bank_type'];

    public function transactionDetail()
    {
        return $this->hasOne(TransactionDetail::class, 'transaction_id', 'id');
    }

    public function transactionProduct()
    {
        return $this->hasMany(TransactionProduct::class, 'transaction_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getTanggal()
    {
        return Carbon::parse($this->attributes['transaction_date'])->translatedFormat('l, d F Y');
    }

    public function transactionCashOut()
    {
        return $this->hasOne(TransactionCashOut::class, 'transaction_id', 'id');
    }
    protected static function booted()
    {
        static::deleting(function (Transaction $Transaction) {
            $Transaction->transactionDetail()->delete();
            $Transaction->transactionProduct()->delete();
            $Transaction->user()->delete();
            $Transaction->getTanggal()->delete();
            $Transaction->transactionCashOut()->delete();
        });
    }
}

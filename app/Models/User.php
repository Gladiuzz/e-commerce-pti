<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username', 'email', 'password', 'role','status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }

    public function transactionCashOut()
    {
        return $this->hasMany(TransactionCashOut::class, 'user_id', 'id');
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'driver_id', 'id');
    }

    protected static function booted()
    {
        static::deleting(function (User $User) {
            $User->transaction()->delete();
            $User->product()->delete();
            $User->transactionCashOut()->delete();
        });
    }
}

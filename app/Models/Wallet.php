<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','total_price','total_fees','total_amount','status','paid_at'];

    public function items() {
        return $this->hasMany(WalletItems::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}

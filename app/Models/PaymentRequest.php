<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;
    protected $fillable = ['user_id ','status','paid_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function request_wallet() {
        return $this->belongsTo(Wallet::class,'wallet_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletItems extends Model
{
    protected $fillable = ['wallet_id','order_id','user_id','service_id','user_service_id',
        'service_title', 'system_fees', 'system_fees_percent', 'service_price', 'service_total_amount',
        'client_id','paid_at','status'
    ];
    use HasFactory;

    public function wallet() {
        return $this->belongsTo(Wallet::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function client() {
        return $this->belongsTo(Client::class);
    }
}

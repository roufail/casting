<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','client_id','user_id'];

    public function messages() {
        return $this->hasMany(ChatMessages::class);
    }
    public function payer() {
        return $this->belongsTo(User::class,"user_id",'id');
    }
    public function client() {
        return $this->belongsTo(Client::class);
    }
    public function order() {
        return $this->belongsTo(Order::class);
    }
}

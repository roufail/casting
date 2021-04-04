<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [            
            "user_id",
            "client_id",
            "service_id",
            "user_service_id",
            "status",
            "price",
    ];

    public function userservice(){
        return $this->belongsTo(UserService::class,'user_service_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function incoming(){
        return $this->hasOne(Incoming::class);
    }

    public function outgoing(){
        return $this->hasOne(Outgoing::class);
    }

    public function chat(){
        return $this->hasOne(Chat::class);
    }

}

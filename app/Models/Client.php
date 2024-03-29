<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Client extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'country',
        'image',
        'active',
        'phone',
        'firebase_token'   
    ];

    protected $hidden = ['password'];
    
    public function orders() {
        return $this->hasMany(Order::class);
    }


    public function password_recovery() {
        return $this->hasOne(PasswordRecovery::class,"user_id","id")->where("user_type","client");
    }

    public function favorite_payers() {
        return $this->hasMany(Favorite::class);
    }



    public function receivesBroadcastNotificationsOn() {
        return 'client.'.$this->id;
    }


    public function routeNotificationForFcm() {
        return $this->firebase_token;
    }
    

}

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
    ];
    public function orders() {
        return $this->hasMany(Order::class);
     }

}

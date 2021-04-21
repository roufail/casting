<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $fillable = ['service_id','user_id','user_service_id','client_id','rate','feedback'];

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function userservice(){
        return $this->belongsTo(UserService::class,'user_service_id','id');
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }

}
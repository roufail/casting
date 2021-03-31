<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    use HasFactory;
    protected $fillable = ['service_id','category_id','user_id','price','work_type'];

    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function ratings(){
        return $this->hasMany(Rate::class);
    }
    
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

 
}

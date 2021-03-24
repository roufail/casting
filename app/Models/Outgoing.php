<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outgoing extends Model
{
    use HasFactory;
    protected $fillable = ["order_id","incoming_id","fees","total"];
    public function order(){
        return $this->belongsTo(Order::class);
    }

}

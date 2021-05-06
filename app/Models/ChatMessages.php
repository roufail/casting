<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessages extends Model
{
    use HasFactory;
    protected $fillable = ['chat_id','user_id','user_type','message','message_type'];
    public function chat() {
        return $this->belongsTo(Chat::class);
    }

    public function client() {
        return $this->belongsTo(Client::class,"user_id");
    }
    public function payer() {
        return $this->belongsTo(User::class,"user_id");
    }
}

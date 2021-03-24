<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessages extends Model
{
    use HasFactory;
    protected $fillable = ['chat_id','user_id','user_type','message'];
    public function chat() {
        return $this->belongsTo(Chat::class);
    }

}

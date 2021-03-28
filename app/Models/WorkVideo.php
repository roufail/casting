<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkVideo extends Model
{
    use HasFactory;
    protected $table = "payer_work_videos";
    protected $fillable = ['payer_id','video_url'];
}

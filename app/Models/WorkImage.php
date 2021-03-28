<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkImage extends Model
{
    use HasFactory;
    protected $table = "payer_work_images";
    protected $fillable = ['payer_id','image_url'];

}

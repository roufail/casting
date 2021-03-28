<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayerData extends Model
{
    use HasFactory;
    protected $fillable = ['job_title','prev_work','bio'];
}

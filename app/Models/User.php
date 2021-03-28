<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country',
        'image',
        'active',
        'bio',
        'dob',
        'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function services() {
        return $this->hasMany(UserService::class);
    }
    public function orders() {
        return $this->hasMany(Order::class);
    }
    public function payer_data() {
        return $this->hasOne(PayerData::class,"payer_id","id");
    }
    public function work_images() {
        return $this->hasMany(WorkImage::class,"payer_id","id");
    }
    public function work_video() {
        return $this->hasOne(WorkVideo::class,"payer_id","id");
    }

    public function password_recovery() {
        return $this->hasOne(PasswordRecovery::class)->where("user_type","payer");
    }



    public function rating()
    {
        return $this->hasMany(Rate::class);
    }

    public function rating_stars(){
        $original_rating = $this->rating()->get();
        $rating_5 = $this->get_rate_count(5,$original_rating);
        $rating_4 = $this->get_rate_count(4,$original_rating);
        $rating_3 = $this->get_rate_count(3,$original_rating);
        $rating_2 = $this->get_rate_count(2,$original_rating);
        $rating_1 = $this->get_rate_count(1,$original_rating);
        $rating = (5 * $rating_5 + 4 * $rating_4 + 3 * $rating_3 + 2 * $rating_2 + 1 * $rating_1);

        $rating_sum = ($rating_5 + $rating_4 + $rating_3 + $rating_2 + $rating_1);
        if($rating_sum <= 0)
        {
            return 0;
        }

        $rating = $rating / $rating_sum;

        return (int)round($rating,1);
    }

    public function get_rate_count($rate_number,$original_rating) {
        $rating = $original_rating->filter(function($rate) use($rate_number) {
            if ($rate->rate == $rate_number) {
                return true;
            }
        })->count();
        return  $rating;
    }



    public function receivesBroadcastNotificationsOn() {
        return 'payer.'.$this->id;
    }


    public function findForPassport($username) {
        return $this->where('phone', $username)->first();
    }



 }

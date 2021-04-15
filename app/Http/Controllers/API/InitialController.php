<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InitialController extends BaseController
{
    public function initial(){
        $data = [
            "fees" => (double)\App\Models\Setting::where('setting_key','percentage')->pluck('setting_value','setting_key')->toArray()['percentage'],
            "work_durations" => [
                'hourly','daily','weekly'
            ],
            "main_services" => \App\Models\Service::inRandomOrder()->take(20)->get(['id','title']),
            "categories" => \App\Models\Category::inRandomOrder()->take(20)->get(['id','title'])
        ];
        return  $this->success($data,'Initial data');
    }

    public function settings(){
        $data = [
            "terms_and_conditions" => route("terms_and_conditions"),
            "privacy_policy"       => route("privacy_policy"),
        ];
        return  $this->success($data,'Settings data');
    }
}

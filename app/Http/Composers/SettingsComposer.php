<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\Setting;

class SettingsComposer
{
    private $settings;

    public function compose(View $view)
    {
        if (!$this->settings) {
            $this->settings = Setting::pluck('setting_value','setting_key')->toArray();
            session(['settings' => $this->settings]);
        }

        return $view->with('settings',$this->settings);

    }
}


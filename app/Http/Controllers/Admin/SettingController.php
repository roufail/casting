<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
Use Alert,Storage;
use App\Http\Requests\Admin\Service\ServiceRequest;
use App\Http\Requests\Admin\Settings\SettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Setting $settings)
    {
        $settings = Setting::pluck('setting_value','setting_key')->toArray();
        return view("admin.settings.form",compact('settings'));
    }

    public function store(SettingRequest $request){
        $settings = $request->validated()['settings'];
        if(isset($settings['logo'])){
            $setting = Setting::where('setting_key','logo')->first();
            if($setting) {
                Storage::disk('settings')->delete($setting->logo);
            }

            $logo = $settings['logo']->store("/","settings");
            unset($settings['logo']);
            $settings['logo'] = Storage::disk('settings')->url($logo);
        }
        foreach($settings as $key => $value) {
            Setting::updateOrCreate(['setting_key' => $key],[
                'setting_key'   => $key,
                'setting_value' => $value,
            ]);
        }
        Alert::toast('<h4>تم تعديل الاعدادات بنجاح</h4>','success');
        return redirect(route('admin.settings.index'));
    }


    public function delete_image(Request $request) {
        if($request->ajax()){
            $setting = Setting::where('setting_key','logo')->first();
            $logo_ar = explode("/",$setting->setting_value);
            $logo = end($logo_ar);
            Storage::disk('settings')->delete($logo);
            $setting->update(['setting_value' => ""]);
            return true;
        }
    }



}

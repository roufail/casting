<?php
if(!function_exists('load_notification')){
    function load_notification($notification) {
        $class_name      = ucfirst($notification['data']['reported_type']);
        $class = 'App\\Models\\' . $class_name;
        $reported        = $class::find($notification['data']['reported_id']);
        return [
            "notification"   => $notification['data']['notification'],
            "type"           => $notification['data']['not_type'],
            "read_at"        => $notification->read_at,
            "reported"       => [ 
                'id'    => $notification['data']['reported_id'],
                'type'  => $notification['data']['reported_type'],
                'name'  => $reported->name,
                'image' => $reported->image ? Storage::disk($notification['data']['reported_type']."s")->url($reported->image) : null,
            ]
        ];
    }
}
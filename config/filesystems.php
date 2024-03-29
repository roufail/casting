<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'users' => [
            'driver' => 'local',
            'root' => storage_path('app/public/users'),
            'url' => env('APP_URL').'/storage/users',
            'visibility' => 'public',
        ],
        'clients' => [
            'driver' => 'local',
            'root' => storage_path('app/public/clients'),
            'url' => env('APP_URL').'/storage/clients',
            'visibility' => 'public',
        ],
        'services' => [
            'driver' => 'local',
            'root' => storage_path('app/public/services'),
            'url' => env('APP_URL').'/storage/services',
            'visibility' => 'public',
        ],
        'categories' => [
            'driver' => 'local',
            'root' => storage_path('app/public/categories'),
            'url' => env('APP_URL').'/storage/categories',
            'visibility' => 'public',
        ],
        'messages' => [
            'driver' => 'local',
            'root' => storage_path('app/public/messages'),
            'url' => env('APP_URL').'/storage/messages',
            'visibility' => 'public',
        ],
        'settings' => [
            'driver' => 'local',
            'root' => storage_path('app/public/settings'),
            'url' => env('APP_URL').'/storage/settings',
            'visibility' => 'public',
        ],
        'dropzone' => [
            'driver' => 'local',
            'root' => storage_path('app/public/dropzone'),
            'url' => env('APP_URL').'/storage/dropzone',
            'visibility' => 'public',
        ],
        'work_images' => [
            'driver' => 'local',
            'root' => storage_path('app/public/work_images'),
            'url' => env('APP_URL').'/storage/work_images',
            'visibility' => 'public',
        ],
        'work_videos' => [
            'driver' => 'local',
            'root' => storage_path('app/public/work_videos'),
            'url' => env('APP_URL').'/storage/work_videos',
            'visibility' => 'public',
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];

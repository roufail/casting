<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('payer.{payer_id}', function ($user, $payer_id) {
    return (int) $user->id === (int) $payer_id;
});


// Broadcast::channel('chat-channel.payer.{payer_id}', function ($user, $payer_id) {
//     return (int) $user->id === (int) $payer_id;
// },['guards' => ['payer-api']]);


// Broadcast::channel('chat-channel.client.{client_id}', function ($user, $client_id) {
//     return (int) $user->id === (int) $client_id;
// },['guards' => ['client-api']]);


Broadcast::channel('admin.{admin_id}', function ($admin, $admin_id) {
    return (int) $admin->id === (int) $admin_id;
},['guards' => ['admin']]);
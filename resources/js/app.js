// require('./bootstrap');

import Echo from "laravel-echo"



window.io = require('socket.io-client');

// window.Echo = new Echo({
//     broadcaster: 'socket.io',
//     host: window.location.hostname + ':6001',
//     auth: {headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
//         }},
// });


// window.Echo = new Echo({
//     broadcaster: 'socket.io',
//     host: window.location.hostname + ':6001',
//     encrypted: true,
//     logToConsole: true,
//     auth: {headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
//     }},
// });

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    client: io,
    auth: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
        }
    },
});

import Echo from 'laravel-echo'

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    auth: {
        headers: {
            'Api-Token': '1',
        }
    }
});

require('./subscribers');
/**
 * Alpine.js
 */
require('alpinejs');

/**
 * Bootstrap 5
 */
require('bootstrap');

/**
 * Video Player
 */
window.Hls = require('hls.js');
window.Plyr = require('plyr');


/**
 * Websockets
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});


/**
 * FilePond
 */
window.FilePond = require('filepond');
window.FilePondPluginFileValidateSize = require('filepond-plugin-file-validate-size');
window.FilePondPluginFileValidateType = require('filepond-plugin-file-validate-type');
window.FilePondPluginImageValidateSize = require('filepond-plugin-image-validate-size');

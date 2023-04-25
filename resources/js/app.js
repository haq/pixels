import Hls from 'hls.js';
import Plyr from 'plyr';

import Pusher from 'pusher-js';
import Echo from 'laravel-echo';

import * as FilePond from 'filepond';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size';

import Alpine from 'alpinejs';

/**
 * Bootstrap 5
 */
require('bootstrap');

/**
 * Video Player
 */
window.Hls = Hls;
window.Plyr = Plyr;

/**
 * Websockets
 */
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.VITE_PUSHER_APP_KEY,
    host: process.env.VITE_PUSHER_HOST,
    port: process.env.VITE_PUSHER_PORT,
    scheme: process.env.VITE_PUSHER_SCHEME,
    cluster: process.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

/**
 * FilePond
 */
window.FilePond = FilePond;
window.FilePondPluginFileValidateSize = FilePondPluginFileValidateSize;
window.FilePondPluginFileValidateType = FilePondPluginFileValidateType;
window.FilePondPluginImageValidateSize = FilePondPluginImageValidateSize;

/**
 * Alpine.js
 */
window.Alpine = Alpine;
Alpine.start();

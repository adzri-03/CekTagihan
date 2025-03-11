import './bootstrap';import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
// import {Html5QrcodeScanner} from "html5-qrcode";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// window.Html5QrcodeScanner = Html5QrcodeScanner;



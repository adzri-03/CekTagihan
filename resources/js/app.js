import './bootstrap';import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import { Html5Qrcode } from "html5-qrcode";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

const pusher = new Pusher("c92509f4a2d5966430c1", {
    cluster: "ap1",
    encrypted: true
});

window.Html5Qrcode = Html5Qrcode;



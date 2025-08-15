/**
 * HTTP: axios + CSRF
 */
import axios from 'axios';

// Nur im Browser (nicht im SSR)
if (typeof window !== 'undefined') {
  window.axios = axios;

  // CSRF aus <meta name="csrf-token" content="...">
  const tokenEl = document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement | null;
  const token = tokenEl?.content ?? null;

  if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
  } else {
    // Hinweis: in Blade sicherstellen, dass @csrf meta gesetzt ist
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
  }

  window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}

/**
 * Echo / Pusher (optional)
 */
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
// if (typeof window !== 'undefined') {
//   window.Pusher = Pusher;
//   window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
//   });
// }

/**
 * HTTP: axios + CSRF
 */
import axios from 'axios';

// Nur im Browser (nicht im SSR)
if (typeof window !== 'undefined') {
  // axios global verfügbar (falls woanders benötigt)
  // @ts-expect-error: attach for convenience
  window.axios = axios;

  // AJAX Header
  axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

  // KORREKTUR: Wir entfernen den Interceptor und kehren zum robusten Standard-Mechanismus von Laravel zurück.
  // Axios wird jetzt angewiesen, das XSRF-TOKEN-Cookie zu lesen und als X-XSRF-TOKEN-Header zu senden.
  // Dies geschieht automatisch vor jeder Anfrage und löst alle Timing-Probleme.
  axios.defaults.xsrfCookieName = 'XSRF-TOKEN';
  axios.defaults.xsrfHeaderName = 'X-XSRF-TOKEN';

  // WICHTIG: Stellt sicher, dass Cookies bei Anfragen mitgesendet werden.
  axios.defaults.withCredentials = true;
}

/**
 * Echo / Pusher (optional)
 */
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
// if (typeof window !== 'undefined') {
//   // @ts-expect-error
//   window.Pusher = Pusher;
//   // @ts-expect-error
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

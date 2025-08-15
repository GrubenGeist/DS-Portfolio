// resources/js/composables/useAnalytics.ts

// Nichts global neu deklarieren – gtag ist über gtag.d.ts typisiert,
// route() kommt global aus global-route.d.ts

interface GtagEvent {
  action: string;
  category: string;
  label?: string;
  value?: number;
}

/**
 * Event an Google Analytics (falls vorhanden) UND an dein Backend schicken.
 */
export const trackEvent = (event: GtagEvent) => {
  // 1) Google Analytics
  if (typeof window !== 'undefined' && typeof window.gtag === 'function') {
    window.gtag('event', event.action, {
      event_category: event.category,
      event_label: event.label,
      value: event.value,
    });
  }

  // 2) Eigenes Backend (API, kein CSRF nötig)
  const url =
    (typeof route === 'function' ? route('api.analytics-events.store') : '') ||
    (typeof route === 'function' ? route('api.track-event') : '') ||
    '/api/analytics-events';

  fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
    body: JSON.stringify({
      category: event.category,
      label: event.label ?? event.action,
    }),
  }).catch((e) => console.error('trackEvent failed:', e));
};

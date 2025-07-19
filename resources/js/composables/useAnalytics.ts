// /resources/js/composables/useAnalytics.ts

import { route } from 'ziggy-js';

// Definiert, wie die gtag-Funktion für TypeScript aussieht
declare global {
  interface Window {
    gtag: (...args: any[]) => void;
  }
}

// Definiert die Struktur für unsere Event-Daten
interface GtagEvent {
  action: string;
  category: string;
  label?: string;
  value?: number;
}

/**
 * Sendet ein benutzerdefiniertes Event an Google Analytics UND an das eigene Backend.
 * @param {GtagEvent} event - Das Event-Objekt mit action, category, etc.
 */
export const trackEvent = (event: GtagEvent) => {
  
  // 1. An Google Analytics senden (falls das Skript geladen wurde)
  if (typeof window.gtag !== 'undefined') {
    window.gtag('event', event.action, {
      event_category: event.category,
      event_label: event.label,
      value: event.value,
    });
  } else {
    console.log('Analytics not loaded, GA event not tracked:', event);
  }

  // 2. An unser eigenes Backend senden
  try {
    // Wir lesen den CSRF-Token aus dem <meta>-Tag der Seite.
    const csrfToken = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content;

    fetch(route('api.track-event'), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        // Der CSRF-Token wird hier als Header mitgeschickt, um die Anfrage zu authentifizieren.
        'X-CSRF-TOKEN': csrfToken || '', 
      },
      body: JSON.stringify(event),
    });
  } catch (error) {
    console.error('Could not log event to own backend:', error);
  }
};

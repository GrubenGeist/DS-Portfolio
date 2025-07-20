import { route } from 'ziggy-js';
// WICHTIG: Importiere die globale axios-Instanz, die in bootstrap.js konfiguriert wurde.
import axios from 'axios';

interface TrackClickBinding {
  category: string;
  label: string;
}

export const trackClick = {
  mounted(el: HTMLElement, binding: { value: TrackClickBinding }) {
    const handler = () => {
      // Wir verwenden jetzt die globale axios-Instanz, die den CSRF-Token enthält.
      axios.post(route('api.track-event'), {
        category: binding.value.category,
        label: binding.value.label,
      })
      .then(response => {
        // Optional: Log bei Erfolg
        console.log('Event tracked:', binding.value);
      })
      .catch(error => {
        // WICHTIG: Log bei einem Fehler
        console.error('Failed to track event:', error.response?.data || error.message);
      });
    };

    el.addEventListener('click', handler);
    // Speichere den Handler, damit wir ihn später entfernen können
    (el as any).__trackClickHandler = handler;
  },
  beforeUnmount(el: HTMLElement) {
    // Räume den Event-Listener auf, um Memory-Leaks zu vermeiden
    if ((el as any).__trackClickHandler) {
      el.removeEventListener('click', (el as any).__trackClickHandler);
    }
  },
};

/*
Diese Direktive enthält die Logik,
um einen Klick-Listener an ein Element zu hängen und unser trackEvent-Composable aufzurufen.
*/

import { trackEvent } from '@/composables/useAnalytics';
import type { Directive } from 'vue';

interface TrackClickValue {
  category: string;
  label: string;
  action?: string;
}

export const trackClick: Directive<HTMLElement, TrackClickValue> = {
  // Diese Funktion wird aufgerufen, wenn das Element in die Seite eingefügt wird.
  mounted(el, binding) {
    // 'el' ist das HTML-Element, auf dem die Direktive sitzt.
    // 'binding.value' ist das Objekt, das wir übergeben (z.B. { category: '...', label: '...' }).
    
    const eventDetails = binding.value;

    if (!eventDetails || !eventDetails.category || !eventDetails.label) {
      console.warn('v-track-click: "category" and "label" are required.', el);
      return;
    }

    // Wir fügen einen Klick-Listener hinzu.
    el.addEventListener('click', () => {
      // Beim Klick rufen wir unsere zentrale trackEvent-Funktion auf.
      trackEvent({
        action: eventDetails.action || 'click', // Standard-Aktion ist 'click'
        category: eventDetails.category,
        label: eventDetails.label,
      });
    });
  },
};
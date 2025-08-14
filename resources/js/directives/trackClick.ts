// In /resources/js/directives/trackClick.ts

import { type Directive } from 'vue';
import { route } from 'ziggy-js';
// KORREKTUR: Wir importieren unseren Consent-Composable
import { useConsent } from '@/composables/useConsent';

interface TrackClickBinding {
    category: string;
    action?: string;
    label: string;
}

export const trackClick: Directive<HTMLElement, TrackClickBinding> = {
    mounted(el, binding) {
        // Wir holen uns den reaktiven Zustand aus dem Composable
        const { consentState } = useConsent();

        const handler = () => {
            // KORREKTUR: Die Anfrage wird nur gesendet, WENN die Zustimmung für Analytics vorliegt.
            if (consentState.analytics) {
                const { category, action = 'click', label } = binding.value;

                // Hole das CSRF-Token, das jetzt nach der Zustimmung existiert
                const csrfToken = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content;

                // Sende das Event an den Server
                fetch(route('api.track-event'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || '',
                    },
                    body: JSON.stringify({
                        category,
                        action,
                        label,
                    }),
                }).catch(error => {
                    console.error('Tracking event failed to send:', error);
                });

                console.log(`Tracking Event Sent: ${category} - ${label}`);
            } else {
                console.log('Tracking Event NOT Sent: No analytics consent.');
            }
        };

        // Füge den Event-Listener zum Element hinzu
        el.addEventListener('click', handler);

        // Speichere den Handler am Element, damit wir ihn in `unmounted` wieder entfernen können
        (el as any).__vueTrackClickHandler = handler;
    },
    unmounted(el) {
        // Räume den Event-Listener auf, wenn die Komponente zerstört wird
        if ((el as any).__vueTrackClickHandler) {
            el.removeEventListener('click', (el as any).__vueTrackClickHandler);
        }
    },
};


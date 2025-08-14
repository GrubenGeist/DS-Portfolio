import { reactive, readonly } from 'vue';
import { route } from 'ziggy-js';
import { useGoogleAnalytics } from './useGoogleAnalytics';

interface ConsentState {
  necessary: boolean;
  analytics: boolean;
  marketing: boolean;
  bannerVisible: boolean;
}

const consentState = reactive<ConsentState>({
  necessary: true,
  analytics: false,
  marketing: false,
  bannerVisible: false,
});

const CONSENT_STORAGE_KEY = 'cookie_consent';

export const loadConsent = () => {
  const storedConsent = localStorage.getItem(CONSENT_STORAGE_KEY);
  if (storedConsent) {
    const parsedConsent = JSON.parse(storedConsent);
    consentState.analytics = parsedConsent.analytics || false;
    consentState.marketing = parsedConsent.marketing || false;
    consentState.bannerVisible = false;
  } else {
    consentState.bannerVisible = true;
  }
};

export function useConsent() {
    const { updateConsent } = useGoogleAnalytics();

    const saveConsent = (newConsent: { analytics: boolean; marketing: boolean }) => {
      consentState.analytics = newConsent.analytics;
      consentState.marketing = newConsent.marketing;
      consentState.bannerVisible = false;

      localStorage.setItem(CONSENT_STORAGE_KEY, JSON.stringify({
        analytics: consentState.analytics,
        marketing: consentState.marketing,
      }));

      // Sende die Zustimmung an Google.
      updateConsent(newConsent);

      // Setze das Signal-Cookie für das Backend.
      document.cookie = "laravel_consent=true; path=/; max-age=31536000";

      // Sende die Zustimmung an den Server (fürs Dashboard-Tracking).
      fetch(route('api.consent.store'), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                analytics: consentState.analytics,
              marketing: consentState.marketing,
            }),
      })
      .catch(error => console.error('Failed to send consent decision:', error))
      .finally(() => {
          // Lade die Seite neu, damit die Session gestartet wird.
          window.location.reload();
      });
    };

    return {
        consentState: readonly(consentState),
        loadConsent,
        saveConsent,
    };
}
import { reactive, readonly } from 'vue';
import { route } from 'ziggy-js';

// Definiert die Struktur des Consent-Status
interface ConsentState {
  necessary: boolean;
  analytics: boolean;
  marketing: boolean;
  bannerVisible: boolean;
}

// Der reaktive Zustand, der in der gesamten Anwendung geteilt wird
const consentState = reactive<ConsentState>({
  necessary: true,
  analytics: false,
  marketing: false,
  bannerVisible: false,
});

const CONSENT_STORAGE_KEY = 'cookie_consent';

// Lädt den gespeicherten Zustand aus dem localStorage
const loadConsent = () => {
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

// Speichert die Zustimmung und sendet sie an das Backend
const saveConsent = async (newConsent: { analytics: boolean; marketing: boolean }) => {
  // 1. Zustand im Frontend aktualisieren
  consentState.analytics = newConsent.analytics;
  consentState.marketing = newConsent.marketing;
  consentState.bannerVisible = false;

  // 2. Zustand im localStorage für zukünftige Besuche speichern
  localStorage.setItem(CONSENT_STORAGE_KEY, JSON.stringify({
    analytics: consentState.analytics,
    marketing: consentState.marketing,
  }));

  // 3. Zustand an das Backend senden
  try {
    const csrfToken = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content;

    const response = await fetch(route('api.consent.store'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken || '',
        },
        body: JSON.stringify({
            analytics: consentState.analytics,
        }),
    });
    
    if (!response.ok) {
        // Wirft einen Fehler, wenn der Server-Status nicht erfolgreich war
        throw new Error(`Server responded with ${response.status}`);
    }

  } catch (error) {
    // Loggt nur noch, wenn tatsächlich ein Fehler auftritt
    console.error('Failed to send consent decision:', error);
  }
};

// Die Funktionen, die für andere Komponenten verfügbar gemacht werden
export function useConsent() {
  return {
    consentState: readonly(consentState),
    loadConsent,
    saveConsent,
  };
}

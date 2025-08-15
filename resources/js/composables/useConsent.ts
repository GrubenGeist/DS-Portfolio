import { reactive, readonly } from 'vue';
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
  try {
    const stored = localStorage.getItem(CONSENT_STORAGE_KEY);
    if (stored) {
      const parsed = JSON.parse(stored);
      consentState.analytics = !!parsed.analytics;
      consentState.marketing = !!parsed.marketing;
      consentState.bannerVisible = false;
      return;
    }
  } catch (e) {
    console.warn('[consent] failed to read localStorage:', e);
  }
  consentState.bannerVisible = true;
};

export function useConsent() {
  const { updateConsent } = useGoogleAnalytics();

  const saveConsent = async (newConsent: { analytics: boolean; marketing: boolean }) => {
    // 1) State + localStorage
    consentState.analytics = newConsent.analytics;
    consentState.marketing = newConsent.marketing;
    consentState.bannerVisible = false;

    try {
      localStorage.setItem(
        CONSENT_STORAGE_KEY,
        JSON.stringify({ analytics: consentState.analytics, marketing: consentState.marketing }),
      );
    } catch (e) {
      console.warn('[consent] failed to write localStorage:', e);
    }

    // 2) GA Consent Mode
    updateConsent(newConsent);

    // 3) Signal-Cookie für Backend (z. B. um Session zu starten)
    document.cookie = 'laravel_consent=true; path=/; max-age=31536000';

    // 4) Optional an dein Backend melden (falls Route existiert)
    try {
      const csrf = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || '';
      // globales Ziggy route() – mit Fallback
      const url = typeof route === 'function' ? route('api.consent.store') : '/api/consent';

      await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),
        },
        body: JSON.stringify({
          analytics: consentState.analytics,
          marketing: consentState.marketing,
        }),
      });
    } catch (e) {
      console.warn('[consent] failed to notify server:', e);
    } finally {
      // 5) Seite neu laden, damit Axios/Session/Guards sicher greifen
      window.location.reload();
    }
  };

  return {
    consentState: readonly(consentState),
    loadConsent,
    saveConsent,
  };
}

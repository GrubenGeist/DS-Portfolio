import { reactive, readonly } from 'vue';
import { useGoogleAnalytics } from './useGoogleAnalytics';
import { router } from '@inertiajs/vue3';
import type { VisitOptions } from '@inertiajs/core'; 

interface ConsentState {
  necessary: boolean;
  analytics: boolean;
  marketing: boolean;
  bannerVisible: boolean;
}

const CONSENT_STORAGE_KEY = 'cookie_consent';
const CONSENT_VERSION = 1;

const consentState = reactive<ConsentState>({
    necessary: true,
    analytics: false,
    marketing: false,
    bannerVisible: false,
});

export const loadConsent = () => {
    try {
        const stored = localStorage.getItem(CONSENT_STORAGE_KEY);
        if (stored) {
            const parsed = JSON.parse(stored);

            // Prüfen, ob Version noch gültig ist
            if (parsed.version !== CONSENT_VERSION) {
                console.info('[consent] Outdated consent version, showing banner again');
                consentState.bannerVisible = true;
                return;
            }

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
    //const { updateConsent } = useGoogleAnalytics();
    const { updateGAConsent: updateConsent } = useGoogleAnalytics();

    const saveConsent = async (newConsent: { analytics: boolean; marketing: boolean }) => {
        // 1) State + localStorage
        consentState.analytics = newConsent.analytics;
        consentState.marketing = newConsent.marketing;
        consentState.bannerVisible = false;

        try {
            localStorage.setItem(
                CONSENT_STORAGE_KEY,
                JSON.stringify({
                    version: CONSENT_VERSION, // 👉 immer mitspeichern
                    analytics: consentState.analytics,
                    marketing: consentState.marketing,
                }),
            );
        } catch (e) {
            console.warn('[consent] failed to write localStorage:', e);
        }

        // 2) GA Consent Mode
        updateConsent(newConsent);

        // 3) Signal-Cookie für Backend
        document.cookie = 'laravel_consent=true; path=/; max-age=31536000; SameSite=Lax';
        // Für HTTPS später:
        // document.cookie = 'laravel_consent=true; path=/; max-age=31536000; SameSite=Lax; Secure';

        // 4) Optional an dein Backend melden
        try {
            const csrf = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || '';
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
            router.reload({ preserveScroll: true } as Partial<VisitOptions>);
        }
    };

    return {
        consentState: readonly(consentState),
        loadConsent,
        saveConsent,
    };
}

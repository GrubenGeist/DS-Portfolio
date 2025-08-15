// resources/js/composables/useGoogleAnalytics.ts

type ConsentUpdate = {
  analytics: boolean;
  marketing: boolean;
  // optional:
  // personalization?: boolean;
  // security?: boolean;
};

const GA_ID = (import.meta.env.VITE_GA_ID as string | undefined) ?? 'G-XXXXXXXXXX';

// idempotenter Guard gegen Mehrfach-Init
let gaInitialized = false;

function ensureGtag() {
  if (typeof window === 'undefined') return;
  window.dataLayer = window.dataLayer || [];
  // queue-basierte Fallback-Implementierung
  window.gtag =
    window.gtag ||
    function gtag(...args: any[]) {
      window.dataLayer.push(args as any);
    };
}

export function useGoogleAnalytics() {
  function init() {
    if (typeof window === 'undefined') return;
    if (gaInitialized) return;
    if (!GA_ID || !GA_ID.startsWith('G-')) return; // echte GA4-ID nötig

    ensureGtag();

    // Consent Mode v2: Defaults
    window.gtag('consent', 'default', {
      ad_storage: 'denied',
      ad_user_data: 'denied',
      ad_personalization: 'denied',
      analytics_storage: 'denied',
      security_storage: 'granted',
    });

    // GA Tag laden (nur einmal)
    if (!document.getElementById('ga-script')) {
      const script = document.createElement('script');
      script.id = 'ga-script';
      script.async = true;
      script.src = `https://www.googletagmanager.com/gtag/js?id=${GA_ID}`;
      document.head.appendChild(script);
    }

    window.gtag('js', new Date());
    // Wichtig: Auto-Pageview AUS, wir tracken manuell
    window.gtag('config', GA_ID, { send_page_view: false });

    gaInitialized = true;
  }

  function updateConsent(consent: ConsentUpdate) {
    if (typeof window === 'undefined') return;
    ensureGtag();

    window.gtag('consent', 'update', {
      analytics_storage: consent.analytics ? 'granted' : 'denied',
      ad_storage: consent.marketing ? 'granted' : 'denied',
      ad_user_data: consent.marketing ? 'granted' : 'denied',
      ad_personalization: consent.marketing ? 'granted' : 'denied',
      // security_storage: 'granted', // optional konstant
    });
  }

  // Manuelles Pageview (z.B. bei Inertia-Navigation)
  function pageview(path?: string) {
    if (typeof window === 'undefined' || !GA_ID) return;
    ensureGtag();
    window.gtag('event', 'page_view', path ? { page_path: path } : undefined);
  }

  return { init, updateConsent, pageview };
}

import { usePage } from '@inertiajs/vue3';

// Konsistente Benennung der Umgebungsvariable
const GA_MEASUREMENT_ID = import.meta.env.VITE_GA_MEASUREMENT_ID as string | undefined;

type ConsentUpdate = {
    analytics: boolean;
    marketing: boolean;
};

// Guard gegen Mehrfach-Initialisierung
let gaInitialized = false;

function ensureGtag() {
    if (typeof window === 'undefined') return;
    window.dataLayer = window.dataLayer || [];
    // Fallback-Implementierung, falls gtag noch nicht geladen ist
    window.gtag =
        window.gtag ||
        function gtag(...args: any[]) {
            window.dataLayer.push(args as any);
        };
}

export function useGoogleAnalytics() {
    function init() {
        if (typeof window === 'undefined' || gaInitialized) return;
        if (!GA_MEASUREMENT_ID || !GA_MEASUREMENT_ID.startsWith('G-')) {
            console.warn('Google Analytics Measurement ID is not set.');
            return;
        }

        ensureGtag();

        // Consent Mode v2: Standardwerte setzen
        window.gtag('consent', 'default', {
            ad_storage: 'denied',
            ad_user_data: 'denied',
            ad_personalization: 'denied',
            analytics_storage: 'denied',
            security_storage: 'granted',
        });

        // GA Tag laden
        if (!document.getElementById('ga-script')) {
            const script = document.createElement('script');
            script.id = 'ga-script';
            script.async = true;
            script.src = `https://www.googletagmanager.com/gtag/js?id=${GA_MEASUREMENT_ID}`;
            document.head.appendChild(script);
        }

        window.gtag('js', new Date());
        window.gtag('config', GA_MEASUREMENT_ID, { send_page_view: false });

        gaInitialized = true;
        console.log('Google Analytics initialized with default consent.');
    }

    function updateGAConsent(consent: ConsentUpdate) {
        if (typeof window === 'undefined') return;
        ensureGtag();

        window.gtag('consent', 'update', {
            analytics_storage: consent.analytics ? 'granted' : 'denied',
            ad_storage: consent.marketing ? 'granted' : 'denied',
            ad_user_data: consent.marketing ? 'granted' : 'denied',
            ad_personalization: consent.marketing ? 'granted' : 'denied',
        });
        console.log('Google Analytics consent updated:', consent);
    }

    function trackPageView(path?: string) {
        if (typeof window === 'undefined' || !GA_MEASUREMENT_ID) return;
        ensureGtag();
        const page = usePage();

        window.gtag('event', 'page_view', {
            page_title: document.title,
            page_location: page.props.ziggy.url as string,
            page_path: path || location.pathname,
        });
    }

    return {
        init,
        updateGAConsent,
        trackPageView,
    };
}
/* ergänzen in der .env VITE_GA_MEASUREMENT_ID=G-K0JB88ZBCF */
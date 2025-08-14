export function useGoogleAnalytics() {
    // HINWEIS: Sobald du deinen Account hast, ersetze diesen Platzhalter.
    const GA_MEASUREMENT_ID = 'G-XXXXXXXXXX'; // <-- ERSETZE DAS MIT DEINER ECHTEN MESS-ID

    const init = () => {
        // Verhindert mehrfaches Initialisieren
        if (document.getElementById('ga-script') || !GA_MEASUREMENT_ID.startsWith('G-')) return;

        window.dataLayer = window.dataLayer || [];
        function gtag(...args: any[]) {
            window.dataLayer.push(args);
        }
        gtag('js', new Date());

        // Consent Mode v2: Standardmäßig alles ablehnen.
        gtag('consent', 'default', {
            'ad_storage': 'denied',
            'ad_user_data': 'denied',
            'ad_personalization': 'denied',
            'analytics_storage': 'denied'
        });

        const script = document.createElement('script');
        script.id = 'ga-script';
        script.async = true;
        script.src = `https://www.googletagmanager.com/gtag/js?id=${GA_MEASUREMENT_ID}`;
        document.head.appendChild(script);

        gtag('config', GA_MEASUREMENT_ID);
        console.log('Google Analytics initialized with Consent Mode v2 defaults.');
    };

    const updateConsent = (consent: { analytics: boolean; marketing: boolean }) => {
        if (typeof window.gtag === 'function') {
            gtag('consent', 'update', {
                'analytics_storage': consent.analytics ? 'granted' : 'denied',
                'ad_storage': consent.marketing ? 'granted' : 'denied',
                'ad_user_data': consent.marketing ? 'granted' : 'denied',
                'ad_personalization': consent.marketing ? 'granted' : 'denied',
            });
            console.log('Google Analytics consent updated:', consent);
        }
    };

    return { init, updateConsent };
}
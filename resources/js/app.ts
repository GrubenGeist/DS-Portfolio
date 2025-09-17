// resources/js/app.ts
import '../css/app.css';

import { createApp, h, type DefineComponent, watchEffect } from 'vue';
// Der Router wird hier direkt importiert, das ist der korrekte Weg.
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import type { Config as ZiggyConfig } from 'ziggy-js';
import  i18n  from './i18n';
import './bootstrap';

import  trackClickDirective  from './directives/trackClick';

// Consent + Analytics
import { useConsent, loadConsent } from './composables/useConsent';
import { useGoogleAnalytics } from './composables/useGoogleAnalytics';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        // --- i18n-Setup ---
        const initialLocale = (props.initialPage.props.locale as string) || 'de';
        const allMessages = (props.initialPage.props.translations as Record<string, any>) || {};

        i18n.global.locale.value = initialLocale;
        Object.keys(allMessages).forEach((locale) => {
            i18n.global.setLocaleMessage(locale, allMessages[locale]);
        });
        // --- Ende i18n-Setup ---

        const vueApp = createApp({ render: () => h(App, props) });
        vueApp.use(plugin).use(i18n);

        // --- Korrekte Consent & GA Architektur ---
        loadConsent();
        const { consentState } = useConsent();
        vueApp.provide('consent', consentState);

        const { init: initGA, updateGAConsent } = useGoogleAnalytics();

        initGA();

        watchEffect(() => {
            updateGAConsent(consentState);
        });
        // --- Ende Consent & GA Architektur ---

        // Ziggy
        const ziggy = (props.initialPage.props as any)?.ziggy as ZiggyConfig;
        vueApp.use(ZiggyVue, ziggy);

        // Direktiven
        vueApp.directive('track-click', trackClickDirective);

        vueApp.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// Der Event-Listener für Seitenwechsel. Er wird NUR HIER, außerhalb von setup, platziert.
router.on('navigate', () => {
    const { consentState } = useConsent();
    const { trackPageView } = useGoogleAnalytics();

    // Wir prüfen vor jedem Tracking, ob die Zustimmung noch gilt.
    if (consentState.analytics) {
        trackPageView();
    }
});

/* ====== Easter Egg (so lassen) ====== */
const styles = [
    'font-size: 16px',
    'font-family: monospace',
    'background: #000000ff',
    'color: #48ff00ff',
    'padding: 3px 20px',
    'border-radius: 5px',
    'line-height: 1.0',
].join(';');

// ... (console.log etc.)


// const message = `Neugierig? 😉
//-
// | Du schaust dir den Code eines leidenschaftlichen Entwicklers an.|
// | Wenn du auf der Suche nach jemandem mit Liebe zum Detail bist,  |
// | melde dich über das Kontaktformular!                            |
// |                                                                 |
// | Möge die Macht mit dir sein                                     |
//-`;
// console.log(`%c${message}`, styles);
// console.log('Mein GitHub-Profil: https://github.com/grubengeist');
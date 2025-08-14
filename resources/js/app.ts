// resources/js/app.ts

import '../css/app.css';

import { createApp, h, type DefineComponent } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import './bootstrap';
import { initializeTheme } from './composables/useAppearance';
import { trackClick } from '@/directives/trackClick';

// KORREKTUR: Wir importieren jetzt alle notwendigen Consent- und Analytics-Funktionen
import { useConsent, loadConsent } from '@/composables/useConsent';
import { useGoogleAnalytics } from '@/composables/useGoogleAnalytics';

// Deine globale Komponente
import ContactForm from './components/ContactForm.vue';

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        
        // NEUE LOGIK FÜR CONSENT MODE V2
        
        // 1. Lade zuerst den Consent-Status aus dem localStorage
        loadConsent();
        
        // 2. Hole den reaktiven Zustand und die GA-Funktionen
        const { consentState } = useConsent();
        const { init, updateConsent } = useGoogleAnalytics();

        // 3. Initialisiere Google Analytics IMMER.
        // Die `init`-Funktion setzt jetzt die 'denied'-Standards für den Consent Mode v2.
        // HINWEIS: Sobald du deine Mess-ID in useGoogleAnalytics.ts eingetragen hast,
        // entferne die Kommentarzeichen // vor der nächsten Zeile, um alles zu aktivieren.
        // init();

        // 4. Wenn die Zustimmung bereits bei einem früheren Besuch gegeben wurde,
        // sende sofort ein Update an Google für diesen Seitenaufruf.
        if (!consentState.bannerVisible) {
            updateConsent(consentState);
        }

        const vueApp = createApp({ render: () => h(App, props) });

        vueApp.use(plugin);
        vueApp.use(ZiggyVue, props.initialPage.props.ziggy);

        vueApp.directive('track-click', trackClick);
        
        vueApp.component('contact-form', ContactForm);

        vueApp.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// HINWEIS: Der separate 'router.on('navigate')'-Block ist nicht mehr nötig.
// Das 'gtag('config', ...)' in der init-Funktion kümmert sich automatisch
// um das Tracking von Seitenaufrufen in einer Single-Page-Application (SPA).

// Theme wird initialisiert
initializeTheme();

// EASTER EGG
const styles = [
    'font-size: 16px',
    'font-family: monospace',
    'background: #000000ff',
    'color: #48ff00ff',
    'padding: 3px 20px',
    'border-radius: 5px',
    'line-height: 1.0',
].join(';');


// const message = `Neugierig? 😉                                                     
//-
// | Du schaust dir den Code eines leidenschaftlichen Entwicklers an.|
// | Wenn du auf der Suche nach jemandem mit Liebe zum Detail bist,  |
// | melde dich über das Kontaktformular!                            |
// |                                                                 |
// | Möge die Macht mit dir sein                                     |
//-`;
// 
// console.log(`%c${message}`, styles); 
// console.log('Mein GitHub-Profil: https://github.com/grubengeist');

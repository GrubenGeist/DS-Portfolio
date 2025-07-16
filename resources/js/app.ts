// resources/js/app.ts

import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h, watchEffect } from 'vue'; // watchEffect hinzugefügt
import { ZiggyVue } from 'ziggy-js';
import './bootstrap';
import { initializeTheme } from './composables/useAppearance';
import { router } from '@inertiajs/vue3';
import { trackClick } from '@/directives/trackClick'; // die Direktive


// Für den Cookie Banner
// KORREKTUR 1: Wir importieren nur den Haupt-Hook 'useConsent'.
import { useConsent } from '@/composables/useConsent';
import { loadScript } from '@/lib/loadScript';

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
        
        // NEUE LOGIK FÜR COOKIE-CONSENT
        
        // KORREKTUR 2: Wir rufen den Hook auf und holen uns beide Teile, die er zurückgibt.
        const { consentState, loadConsent } = useConsent();
        // Wir rufen die Funktion auf, um den gespeicherten Zustand zu laden.
        loadConsent();

        // Ein "Wächter", der auf Änderungen im Consent-Status reagiert
        watchEffect(() => {
            // Lade Google Analytics, WENN die Zustimmung für 'analytics' true ist.
            if (consentState.analytics) {
                console.log('Zustimmung für Analytics gegeben. Lade Google Analytics...');
                loadScript('https://www.googletagmanager.com/gtag/js?id=DEINE_GTAG_ID', 'google-analytics')
                    .then(() => {
                        // Initialisiere GTag, nachdem das Skript geladen ist
                        (window as any).dataLayer = (window as any).dataLayer || [];
                        function gtag(...args: any[]) { (window as any).dataLayer.push(args); }
                        gtag('js', new Date());
                        gtag('config', 'DEINE_GTAG_ID');
                        console.log('Google Analytics geladen.');
                    })
                    .catch(error => console.error(error));
            }
            // Hier könntest du weitere 'if'-Bedingungen für andere Skripte hinzufügen
            // if (consentState.marketing) { ... }
        });


        const vueApp = createApp({ render: () => h(App, props) });

        vueApp.use(plugin);
        vueApp.use(ZiggyVue, props.initialPage.props.ziggy);

        vueApp.directive('track-click', trackClick); //Registriere die Direktive unter dem Namen 'track-click'
        
        vueApp.component('contact-form', ContactForm);

        vueApp.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// Seitenaufrufe für SPA manuell tracken
router.on('navigate', (event) => {
  // Prüfe, ob die gtag-Funktion existiert
  if (typeof window.gtag !== 'undefined') {
    // Sende ein 'page_view' Event mit der neuen URL
    //Wichtig: Ersetze auch hier DEINE_GTAG_ID durch deine echte Google Analytics ID
    window.gtag('config', 'DEINE_GTAG_ID', {
      page_path: event.detail.page.url,
    });
  }
});

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
